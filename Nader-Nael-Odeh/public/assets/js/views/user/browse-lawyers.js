window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.browseLawyers = {
    init: function() {
        this.renderLawyers();
        this.initSearch();
    },
    renderLawyers: function(filter = '') {
        const lawyers = app.db.users.filter(u => u.role === 'Lawyer' && u.status === 'Active');
        const container = document.getElementById("lawyers-list");
        if (!container) return;

        const filtered = lawyers.filter(l => 
            l.name.toLowerCase().includes(filter.toLowerCase()) || 
            l.specialization.toLowerCase().includes(filter.toLowerCase())
        );

        if (filtered.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 text-muted">No lawyers found matching your search.</div>';
            return;
        }

        container.innerHTML = filtered.map(l => `
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <img src="${l.avatar}" class="rounded-circle mb-3 border p-1" width="80" height="80">
                        <h5 class="fw-bold mb-1">${l.name}</h5>
                        <p class="text-primary small fw-semibold mb-2">${l.specialization || 'General Legal Counsel'}</p>
                        <p class="text-muted small mb-3">${l.bio ? l.bio.substring(0, 60) + '...' : 'Professional legal expert available for consultation.'}</p>
                        <a href="../public/lawyer-profile.html?id=${l.id}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-4">View Profile</a>
                    </div>
                </div>
            </div>
        `).join('');
    },
    initSearch: function() {
        const input = document.getElementById('lawyer-search');
        if (input) {
            input.addEventListener('input', (e) => {
                this.renderLawyers(e.target.value);
            });
        }
    }
};
