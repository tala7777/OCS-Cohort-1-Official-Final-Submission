window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.myArticles = {
    init: function() {
        this.renderList();
        this.initForm();
        this.populateCategories();
    },

    populateCategories: function() {
        const select = document.getElementById('art-category');
        if (!select) return;
        
        // Use unified active categories
        const cats = app.storage.getActiveCategories();
        select.innerHTML = '<option value="">Select Category</option>' + 
            cats.map(c => `<option value="${c.name}">${c.name}</option>`).join('');
    },

    renderList: function() {
        const currentUser = app.db.currentUser;
        const articles = app.storage.get(app.storage.keys.articles).filter(a => a.authorId === currentUser.id);
        const container = document.getElementById("articles-list");
        if (!container) return;

        if (articles.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 text-muted"><i class="fas fa-file-alt fa-3x mb-3 opacity-20"></i><p>You haven\'t published any articles yet.</p></div>';
            return;
        }

        container.innerHTML = articles.map(a => `
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            ${app.storage.getCategoryBadge(a.category)}
                            <small class="text-muted">${a.date}</small>
                        </div>
                        <h5 class="fw-bold mb-3">${a.title}</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="app.views.myArticles.openEditModal(${a.id})">Edit</button>
                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="app.views.myArticles.handleDelete(${a.id})">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');

        if (window.app.checkLawyerStatus) window.app.checkLawyerStatus();
    },

    initForm: function() {
        const btn = document.getElementById('saveArticleBtn');
        if (btn) {
            btn.onclick = () => {
                const id = document.getElementById('art-id').value;
                const title = document.getElementById('art-title').value;
                const cat = document.getElementById('art-category').value;
                const content = document.getElementById('art-content').value;

                if (!title || !cat || !content) return app.storage.showToast("Please fill all fields.", "error");

                let articles = app.storage.get(app.storage.keys.articles);
                const currentUser = app.db.currentUser;

                if (id) {
                    const index = articles.findIndex(a => a.id == id);
                    articles[index].title = title;
                    articles[index].category = cat;
                    articles[index].content = content;
                    app.storage.showToast("Article updated successfully");
                } else {
                    const newId = articles.length > 0 ? Math.max(...articles.map(a => a.id)) + 1 : 1;
                    articles.push({
                        id: newId,
                        title,
                        category: cat,
                        content,
                        authorId: currentUser.id,
                        authorName: currentUser.name,
                        date: new Date().toISOString().split('T')[0],
                        views: 0
                    });
                    app.storage.showToast("Article published successfully");
                }

                app.storage.save(app.storage.keys.articles, articles);
                bootstrap.Modal.getInstance(document.getElementById('articleModal')).hide();
                this.renderList();
            };
        }
    },

    openAddModal: function() {
        document.getElementById('articleModalTitle').textContent = "Write New Article";
        document.getElementById('art-id').value = "";
        document.getElementById('art-title').value = "";
        document.getElementById('art-content').value = "";
        this.populateCategories(); // Refresh categories
    },

    openEditModal: function(id) {
        const articles = app.storage.get(app.storage.keys.articles);
        const a = articles.find(item => item.id == id);
        if (!a) return;

        document.getElementById('articleModalTitle').textContent = "Edit Article";
        document.getElementById('art-id').value = a.id;
        document.getElementById('art-title').value = a.title;
        
        // Handle potentially inactive category in edit
        const select = document.getElementById('art-category');
        this.populateCategories();
        
        // If the current category is inactive, we must add it to the select temporarily or it will lose selection
        const cats = app.storage.get(app.storage.keys.categories);
        const currentCat = cats.find(c => c.name === a.category);
        if (currentCat && !currentCat.is_active) {
            const opt = document.createElement('option');
            opt.value = a.category;
            opt.textContent = a.category + " (Inactive)";
            select.appendChild(opt);
        }
        
        document.getElementById('art-category').value = a.category;
        document.getElementById('art-content').value = a.content;
        
        new bootstrap.Modal(document.getElementById('articleModal')).show();
    },

    handleDelete: function(id) {
        app.storage.confirmAction("Delete Article", "Are you sure? This cannot be undone.", () => {
            let articles = app.storage.get(app.storage.keys.articles);
            const filtered = articles.filter(a => a.id != id);
            app.storage.save(app.storage.keys.articles, filtered);
            app.storage.showToast("Article deleted.");
            this.renderList();
        });
    }
};
