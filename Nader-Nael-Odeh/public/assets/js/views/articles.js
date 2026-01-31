window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.articles = {
    init: function() {
        this.populateFilters();
        this.renderTable();
        this.initEvents();
    },

    populateFilters: function() {
        const select = document.getElementById('category-filter');
        if (!select) return;
        
        const cats = app.storage.get(app.storage.keys.categories);
        cats.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.name;
            opt.textContent = c.name + (c.is_active ? '' : ' (Inactive)');
            select.appendChild(opt);
        });
    },

    initEvents: function() {
        const searchInput = document.getElementById('search-articles');
        const catFilter = document.getElementById('category-filter');
        if (searchInput) searchInput.oninput = () => this.renderTable();
        if (catFilter) catFilter.onchange = () => this.renderTable();
    },

    renderTable: function() {
        const articles = app.storage.get(app.storage.keys.articles);
        const searchInput = document.getElementById('search-articles');
        const catFilter = document.getElementById('category-filter');
        
        const search = searchInput ? searchInput.value.toLowerCase() : "";
        const category = catFilter ? catFilter.value : "";
        
        const tbody = document.querySelector("#articlesTable tbody");
        if (!tbody) return;

        let filtered = articles.filter(a => {
            const matchesSearch = a.title.toLowerCase().includes(search) || a.authorName.toLowerCase().includes(search);
            const matchesCat = !category || a.category === category;
            return matchesSearch && matchesCat;
        });

        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-muted">No articles found.</td></tr>';
            return;
        }

        tbody.innerHTML = filtered.map(a => `
            <tr>
                <td><span class="fw-bold text-dark">${a.title}</span></td>
                <td>${a.authorName}</td>
                <td>${app.storage.getCategoryBadge(a.category)}</td>
                <td><i class="fas fa-eye me-1"></i> ${a.views}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger rounded-circle" onclick="app.views.articles.handleDelete(${a.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                    <a href="../public/article-details.html?id=${a.id}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle ms-1">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </td>
            </tr>
        `).join('');
    },

    handleDelete: function(id) {
        app.storage.confirmAction("Moderate Article", "Are you sure you want to delete this article? This will remove it from the platform permanently.", () => {
            let articles = app.storage.get(app.storage.keys.articles);
            const filtered = articles.filter(a => a.id != id);
            app.storage.save(app.storage.keys.articles, filtered);
            app.storage.showToast("Article deleted as moderator.");
            this.renderTable();
        });
    }
};
