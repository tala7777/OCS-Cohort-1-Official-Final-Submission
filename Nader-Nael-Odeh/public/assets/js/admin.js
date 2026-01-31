window.app = window.app || {};

/**
 * Shared Admin/Dashboard Logic
 */
window.app.admin = {
    init: function() {
        this.initSidebar();
        this.initRoleSwitcher();
        this.initUserDisplay();
        this.checkLawyerStatus();
    },

    initSidebar: function() {
        const sidebarToggle = document.body.querySelector('#sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', event => {
                event.preventDefault();
                document.body.classList.toggle('sb-sidenav-toggled');
                localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
            });
        }
    },

    initRoleSwitcher: function() {
        const switcher = document.getElementById('roleSwitcher');
        if (switcher) {
            const currentUser = app.db.currentUser;
            switcher.value = currentUser.role || 'User';

            switcher.onchange = (e) => {
                const newRole = e.target.value;
                const users = app.storage.get(app.storage.keys.users);
                
                // For mock purposes, find a user with this role
                let targetUser = users.find(u => u.role === newRole);
                if (!targetUser) targetUser = { id: 0, name: "Guest " + newRole, role: newRole };
                
                localStorage.setItem(app.storage.keys.currentUser, JSON.stringify(targetUser));
                
                // Redirect to respective dashboard
                if (newRole === 'Admin') window.location.href = '../admin/dashboard.html';
                else if (newRole === 'Lawyer') window.location.href = '../lawyer/dashboard.html';
                else window.location.href = '../user/dashboard.html';
            };
        }
    },

    initUserDisplay: function() {
        const userDisplay = document.getElementById('navbarUserDisplay');
        if (userDisplay) {
            const user = app.db.currentUser;
            userDisplay.innerHTML = `
                <span class="me-2 d-none d-lg-inline text-gray-600 small">${user.name}</span>
                <img class="img-profile rounded-circle" src="${user.avatar || 'https://ui-avatars.com/api/?name=' + user.name}" width="30" height="30">
            `;
        }
    },

    checkLawyerStatus: function() {
        const user = app.db.currentUser;
        if (user.role === 'Lawyer') {
            const requests = app.storage.get(app.storage.keys.lawyerRequests);
            const myReq = requests.find(r => r.email === user.email);
            
            // Check if there's a pending banner in the DOM
            const container = document.querySelector('.container-fluid');
            if (myReq && myReq.status === 'Pending' && !document.getElementById('pending-banner')) {
                const banner = `
                    <div id="pending-banner" class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4">
                        <i class="fas fa-clock fa-2x me-3 opacity-50"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Verification Pending</h6>
                            <p class="mb-0 small">Your account is currently being reviewed. Some features are restricted until approval.</p>
                        </div>
                    </div>
                `;
                container.prepend(document.createRange().createContextualFragment(banner));
                
                // Disable restricted buttons
                document.querySelectorAll('.restricted-feature').forEach(btn => {
                    btn.classList.add('disabled');
                    btn.setAttribute('title', 'Restricted until account approval');
                    btn.onclick = (e) => { e.preventDefault(); app.storage.showToast("Wait for approval to use this.", "error"); };
                });
            }
        }
    }
};

// Global initialization
document.addEventListener('DOMContentLoaded', () => {
    app.admin.init();
});

// Alias for ease of use in HTML files
window.app.checkLawyerStatus = () => app.admin.checkLawyerStatus();
