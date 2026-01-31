window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.users = {
    init: function() {
        this.renderTable();
        this.initEvents();
    },

    initEvents: function() {
        const searchInput = document.getElementById('search-users');
        const roleFilter = document.getElementById('role-filter');
        if (searchInput) searchInput.oninput = () => this.renderTable();
        if (roleFilter) roleFilter.onchange = () => this.renderTable();
        
        const saveBtn = document.getElementById('saveUserBtn');
        if (saveBtn) saveBtn.onclick = () => this.saveUser();
    },

    renderTable: function() {
        const users = app.storage.get(app.storage.keys.users);
        const searchInput = document.getElementById('search-users');
        const roleFilter = document.getElementById('role-filter');
        
        const search = searchInput ? searchInput.value.toLowerCase() : "";
        const role = roleFilter ? roleFilter.value : "";
        
        const tbody = document.querySelector("#usersTable tbody");
        if (!tbody) return;

        let filtered = users.filter(u => {
            const matchesSearch = u.name.toLowerCase().includes(search) || u.email.toLowerCase().includes(search);
            const matchesRole = !role || u.role === role;
            return matchesSearch && matchesRole;
        });

        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No users found.</td></tr>';
            return;
        }

        tbody.innerHTML = filtered.map(u => `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="${u.avatar}" class="rounded-circle me-2" width="30" height="30">
                        <span class="fw-bold text-dark">${u.name}</span>
                    </div>
                </td>
                <td>${u.email}</td>
                <td><span class="badge ${u.role === 'Lawyer' ? 'bg-primary' : (u.role === 'Admin' ? 'bg-dark' : 'bg-info')}">${u.role}</span></td>
                <td><span class="badge ${u.status === 'Active' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger'}">${u.status}</span></td>
                <td>${u.joined}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light rounded-pill px-3 dropdown-toggle text-xs" type="button" data-bs-toggle="dropdown">Actions</button>
                        <ul class="dropdown-menu border-0 shadow-sm">
                            <li><a class="dropdown-item" href="#" onclick="app.views.users.openDetails(${u.id})"><i class="fas fa-eye me-2 text-primary"></i> Details</a></li>
                            <li><a class="dropdown-item" href="#" onclick="app.views.users.openEditModal(${u.id})"><i class="fas fa-edit me-2 text-info"></i> Edit</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="app.views.users.handleDelete(${u.id})"><i class="fas fa-trash me-2"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        `).join('');
    },

    openDetails: function(id) {
        const user = app.storage.get(app.storage.keys.users).find(u => u.id === id);
        if (!user) return;
        
        let meta = `<p><strong>Email:</strong> ${user.email}</p><p><strong>Joined:</strong> ${user.joined}</p>`;
        if (user.role === 'Lawyer') {
            meta += `<p><strong>Specialization:</strong> ${user.specialization}</p><p><strong>Bio:</strong> ${user.bio || 'N/A'}</p>`;
        }
        
        const content = `
            <div class="text-center mb-4">
                <img src="${user.avatar}" class="rounded-circle mb-3 border p-1" width="100" height="100">
                <h4 class="fw-bold mb-0">${user.name}</h4>
                <span class="badge bg-primary">${user.role}</span>
            </div>
            ${meta}
        `;
        
        document.getElementById('userDetailsBody').innerHTML = content;
        new bootstrap.Modal(document.getElementById('userDetailsModal')).show();
    },

    openEditModal: function(id) {
        const user = app.storage.get(app.storage.keys.users).find(u => u.id === id);
        if (!user) return;

        document.getElementById('editUserId').value = user.id;
        document.getElementById('editUserName').value = user.name;
        document.getElementById('editUserEmail').value = user.email;
        document.getElementById('editUserRole').value = user.role;
        document.getElementById('editUserStatus').value = user.status;

        new bootstrap.Modal(document.getElementById('userEditModal')).show();
    },

    saveUser: function() {
        const id = parseInt(document.getElementById('editUserId').value);
        const name = document.getElementById('editUserName').value;
        const email = document.getElementById('editUserEmail').value;
        const role = document.getElementById('editUserRole').value;
        const status = document.getElementById('editUserStatus').value;

        let users = app.storage.get(app.storage.keys.users);
        const index = users.findIndex(u => u.id === id);
        if (index === -1) return;

        users[index] = { ...users[index], name, email, role, status };
        app.storage.save(app.storage.keys.users, users);
        app.storage.showToast("User updated successfully.");
        bootstrap.Modal.getInstance(document.getElementById('userEditModal')).hide();
        this.renderTable();
    },

    handleDelete: function(id) {
        const user = app.storage.get(app.storage.keys.users).find(u => u.id === id);
        if (!user) return;

        let message = `Are you sure you want to delete user "${user.name}"?`;
        if (user.role === 'User') message += " This will also delete all their questions and associated answers.";
        else if (user.role === 'Lawyer') message += " This will also delete all their answers and articles.";

        app.storage.confirmAction("Delete User", message, () => {
            if (app.storage.deleteUserCascade(id)) {
                this.renderTable();
            }
        });
    }
};
