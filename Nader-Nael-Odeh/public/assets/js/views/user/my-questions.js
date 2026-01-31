window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.myQuestions = {
    init: function() {
        this.populateFilters();
        this.renderQuestions();
        this.initEvents();
    },

    populateFilters: function() {
        const select = document.getElementById('category-filter');
        if (!select) return;
        const cats = app.storage.get(app.storage.keys.categories);
        select.innerHTML = '<option value="">All Categories</option>' + 
            cats.map(c => `<option value="${c.name}">${c.name}${c.is_active ? '' : ' (Inactive)'}</option>`).join('');
    },

    initEvents: function() {
        const searchInput = document.getElementById('search-questions');
        const catFilter = document.getElementById('category-filter');
        const statusFilter = document.getElementById('status-filter');
        const sortFilter = document.getElementById('sort-filter');

        if (searchInput) searchInput.oninput = () => this.renderQuestions();
        if (catFilter) catFilter.onchange = () => this.renderQuestions();
        if (statusFilter) statusFilter.onchange = () => this.renderQuestions();
        if (sortFilter) sortFilter.onchange = () => this.renderQuestions();
    },

    renderQuestions: function() {
        const currentUser = app.db.currentUser;
        const questions = app.storage.get(app.storage.keys.questions).filter(q => q.authorId === currentUser.id);
        const allAnswers = app.storage.get(app.storage.keys.answers);
        
        const search = document.getElementById('search-questions')?.value.toLowerCase() || "";
        const category = document.getElementById('category-filter')?.value || "";
        const status = document.getElementById('status-filter')?.value || "";
        const sort = document.getElementById('sort-filter')?.value || "newest";

        let filtered = questions.filter(q => {
            const matchesSearch = q.title.toLowerCase().includes(search);
            const matchesCat = !category || q.category === category;
            const matchesStatus = !status || q.status === status;
            return matchesSearch && matchesCat && matchesStatus;
        });

        filtered.sort((a,b) => sort === 'newest' ? new Date(b.date) - new Date(a.date) : new Date(a.date) - new Date(b.date));

        const container = document.getElementById("questions-list");
        if (!container) return;

        if (filtered.length === 0) {
            container.innerHTML = '<div class="text-center py-5 text-muted">No questions found.</div>';
            return;
        }

        container.innerHTML = filtered.map(q => {
            const qAnswers = allAnswers.filter(a => a.questionId === q.id);
            return `
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                ${app.storage.getCategoryBadge(q.category)}
                                <h5 class="fw-bold mt-2">${q.title}</h5>
                            </div>
                            <span class="badge ${q.status === 'Open' ? 'bg-soft-warning text-warning' : 'bg-soft-success text-success'} px-3">${q.status}</span>
                        </div>
                        <p class="text-muted small">${q.body.substring(0, 150)}...</p>
                        <div class="d-flex align-items-center pt-3 border-top">
                            <span class="small text-muted"><i class="fas fa-clock me-1"></i> ${q.date}</span>
                            <span class="ms-4 small text-muted"><i class="fas fa-comments me-1"></i> ${qAnswers.length} Answers</span>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="app.views.myQuestions.handleDelete(${q.id})">Delete</button>
                                <a href="../public/question-details.html?id=${q.id}" class="btn btn-sm btn-primary rounded-pill px-3 ms-2">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    },

    handleDelete: function(id) {
        app.storage.confirmAction("Delete Question", "Are you sure? This will delete all answers too.", () => {
            app.storage.deleteQuestionCascade(id);
            this.renderQuestions();
        });
    }
};
