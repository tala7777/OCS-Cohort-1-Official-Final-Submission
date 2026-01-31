window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.lawyerRequests = {
    init: function() {
        this.renderTable();
        this.initEvents();
    },

    initEvents: function() {
        document.getElementById('search-requests').oninput = () => this.renderTable();
        document.getElementById('status-filter').onchange = () => this.renderTable();
    },

    renderTable: function() {
        const requests = app.storage.get(app.storage.keys.lawyerRequests);
        const search = document.getElementById('search-requests').value.toLowerCase();
        const status = document.getElementById('status-filter').value;
        const tbody = document.querySelector("#lawyerRequestsTable tbody");
        if (!tbody) return;

        let filtered = requests.filter(r => {
            const matchesSearch = r.name.toLowerCase().includes(search) || r.email.toLowerCase().includes(search);
            const matchesStatus = !status || r.status === status;
            return matchesSearch && matchesStatus;
        });

        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No requests found.</td></tr>';
            return;
        }

        tbody.innerHTML = filtered.map(r => `
            <tr>
                <td><span class="fw-bold text-dark">${r.name}</span></td>
                <td>${r.email}</td>
                <td>${r.specialization}</td>
                <td>${r.date}</td>
                <td><span class="badge ${r.status === 'Approved' ? 'bg-soft-success text-success' : (r.status === 'Rejected' ? 'bg-soft-danger text-danger' : 'bg-soft-warning text-warning')}">${r.status}</span></td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown">Action</button>
                        <ul class="dropdown-menu border-0 shadow">
                            <li><a class="dropdown-item" href="#" onclick="app.views.lawyerRequests.handleUpdateStatus('${r.id}', 'Approved')">Approve</a></li>
                            <li><a class="dropdown-item" href="#" onclick="app.views.lawyerRequests.handleUpdateStatus('${r.id}', 'Rejected')">Reject</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        `).join('');
    },

    handleUpdateStatus: function(id, newStatus) {
        let requests = app.storage.get(app.storage.keys.lawyerRequests);
        const index = requests.findIndex(r => r.id == id);
        if (index === -1) return;

        requests[index].status = newStatus;
        app.storage.save(app.storage.keys.lawyerRequests, requests);
        app.storage.showToast(`Request ${newStatus} successfully.`);
        this.renderTable();
    }
};
