window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.categories = {
    init: function() {
        this.renderTable();
        this.initEvents();
    },
    renderTable: function() {
        const categories = app.storage.get(app.storage.keys.categories);
        const tbody = document.querySelector("#categoriesTable tbody");
        if (!tbody) return;

        tbody.innerHTML = categories.map(c => {
            const usage = this.checkUsage(c.name);
            return `
                <tr>
                    <td>
                        <div class="fw-bold">${c.name}</div>
                        ${!c.is_active ? '<span class="badge bg-soft-secondary text-secondary text-xs">INACTIVE</span>' : ''}
                    </td>
                    <td>
                        <span class="badge ${usage > 0 ? 'bg-soft-warning text-warning' : 'bg-soft-success text-success'} px-2">
                            ${usage} items in use
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary rounded-circle me-1" onclick="app.views.categories.openEditModal(${c.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-outline-danger rounded-circle" onclick="app.views.categories.handleDelete(${c.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        }).join('');
    },

    checkUsage: function(catName) {
        let count = 0;
        count += app.db.questions.filter(q => q.category === catName).length;
        count += app.db.users.filter(u => u.specialization === catName).length;
        count += app.db.articles.filter(a => a.category === catName).length;
        count += app.db.lawyerRequests.filter(r => r.specialization === catName).length;
        return count;
    },

    initEvents: function() {
        document.getElementById('saveCatBtn').onclick = () => this.saveCategory();
    },

    openAddModal: function() {
        document.getElementById('catModalTitle').textContent = "New Category";
        document.getElementById('catId').value = "";
        document.getElementById('categoryForm').reset();
    },

    openEditModal: function(id) {
        const categories = app.storage.get(app.storage.keys.categories);
        const cat = categories.find(c => c.id === id);
        if (!cat) return;

        document.getElementById('catModalTitle').textContent = "Edit Category";
        document.getElementById('catId').value = cat.id;
        document.getElementById('catName').value = cat.name;
        document.getElementById('catActive').checked = cat.is_active;
        
        const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
        modal.show();
    },

    saveCategory: function() {
        const id = document.getElementById('catId').value;
        const name = document.getElementById('catName').value;
        const isActive = document.getElementById('catActive').checked;

        if (!name) return app.storage.showToast("Name is required", "error");

        let categories = app.storage.get(app.storage.keys.categories);
        if (id) {
            // Edit
            const index = categories.findIndex(c => c.id == id);
            categories[index] = { id: parseInt(id), name, is_active: isActive };
        } else {
            // New
            const newId = categories.length > 0 ? Math.max(...categories.map(c => c.id)) + 1 : 1;
            categories.push({ id: newId, name, is_active: true });
        }

        app.storage.save(app.storage.keys.categories, categories);
        app.storage.showToast("Category saved successfully");
        bootstrap.Modal.getInstance(document.getElementById('categoryModal')).hide();
        this.renderTable();
    },

    handleDelete: function(id) {
        const categories = app.storage.get(app.storage.keys.categories);
        const cat = categories.find(c => c.id === id);
        if (!cat) return;

        const usage = this.checkUsage(cat.name);
        
        if (usage > 0) {
            app.storage.confirmAction("Set Inactive", 
                `This category is used by ${usage} items. It cannot be deleted. Do you want to set it as INACTIVE instead?`, 
                () => {
                    const index = categories.findIndex(c => c.id === id);
                    categories[index].is_active = false;
                    app.storage.save(app.storage.keys.categories, categories);
                    app.storage.showToast("Category set to Inactive.");
                    this.renderTable();
                }
            );
        } else {
            app.storage.confirmAction("Delete Category", `Are you sure you want to delete "${cat.name}"?`, () => {
                const filtered = categories.filter(c => c.id !== id);
                app.storage.save(app.storage.keys.categories, filtered);
                app.storage.showToast("Category deleted permanentely.");
                this.renderTable();
            });
        }
    }
};
