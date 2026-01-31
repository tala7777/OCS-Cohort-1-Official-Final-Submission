window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.userDashboard = {
    init: function() {
        this.renderRecentQuestions();
    },
    renderRecentQuestions: function() {
        const currentUser = app.db.currentUser;
        const questions = app.storage.get(app.storage.keys.questions).filter(q => q.authorId === currentUser.id);
        const container = document.getElementById("recent-questions");
        if (!container) return;

        if (questions.length === 0) {
            container.innerHTML = '<li class="list-group-item text-center py-4 text-muted small">You haven\'t asked any questions yet.</li>';
            return;
        }

        container.innerHTML = questions.slice(0, 5).map(q => `
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <div>
                    <h6 class="mb-1 fw-bold">${q.title}</h6>
                    <small class="text-muted">${q.date} • ${q.category}</small>
                </div>
                <span class="badge ${q.status === 'Open' ? 'bg-soft-warning text-warning' : 'bg-soft-success text-success'} px-3">${q.status}</span>
            </li>
        `).join('');
    }
};
