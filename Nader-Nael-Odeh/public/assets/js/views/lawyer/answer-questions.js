window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.answerQuestions = {
    init: function() {
        this.populateFilters();
        this.renderQuestions();
        this.initEvents();
    },

    populateFilters: function() {
        const select = document.getElementById('category-filter');
        if (!select) return;
        
        const cats = app.storage.get(app.storage.keys.categories); // Show all for filtering
        select.innerHTML = '<option value="">All Categories</option>' + 
            cats.map(c => `<option value="${c.name}">${c.name}${c.is_active ? '' : ' (Inactive)'}</option>`).join('');
    },

    initEvents: function() {
        const searchInput = document.getElementById('search-questions');
        const catFilter = document.getElementById('category-filter');
        const sortFilter = document.getElementById('sort-filter');
        const unansweredToggle = document.getElementById('unanswered-only');

        if (searchInput) searchInput.oninput = () => this.renderQuestions();
        if (catFilter) catFilter.onchange = () => this.renderQuestions();
        if (sortFilter) sortFilter.onchange = () => this.renderQuestions();
        if (unansweredToggle) unansweredToggle.onchange = () => this.renderQuestions();
    },

    renderQuestions: function() {
        const questions = app.storage.get(app.storage.keys.questions);
        const answers = app.storage.get(app.storage.keys.answers);
        
        const search = document.getElementById('search-questions')?.value.toLowerCase() || "";
        const category = document.getElementById('category-filter')?.value || "";
        const sort = document.getElementById('sort-filter')?.value || "newest";
        const onlyUnanswered = document.getElementById('unanswered-only')?.checked;

        let filtered = questions.filter(q => {
            const matchesSearch = q.title.toLowerCase().includes(search) || q.body.toLowerCase().includes(search);
            const matchesCat = !category || q.category === category;
            const matchesAnswers = !onlyUnanswered || q.status === "Open";
            return matchesSearch && matchesCat && matchesAnswers;
        });

        // Sorting
        filtered.sort((a, b) => {
            if (sort === 'newest') return new Date(b.date) - new Date(a.date);
            const aAns = answers.filter(ans => ans.questionId === a.id).length;
            const bAns = answers.filter(ans => ans.questionId === b.id).length;
            if (sort === 'most_answered') return bAns - aAns;
            if (sort === 'least_answered') return aAns - bAns;
            return 0;
        });

        const container = document.getElementById('questions-container');
        if (!container) return;

        if (filtered.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 text-muted">No matching questions found.</div>';
            return;
        }

        container.innerHTML = filtered.map(q => {
            const qAnswers = answers.filter(a => a.questionId === q.id);
            return `
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    ${app.storage.getCategoryBadge(q.category)}
                                    <h5 class="fw-bold mt-2">${q.title}</h5>
                                </div>
                                <span class="badge ${q.status === 'Open' ? 'bg-soft-warning text-warning' : 'bg-soft-success text-success'} px-3">${q.status}</span>
                            </div>
                            <p class="text-muted small mb-4">${q.body.substring(0, 200)}...</p>
                            <div class="d-flex align-items-center pt-3 border-top">
                                <div class="small text-muted"><i class="fas fa-clock me-1"></i> ${q.date}</div>
                                <div class="ms-4 small text-muted"><i class="fas fa-comments me-1"></i> ${qAnswers.length} Answers</div>
                                <button class="btn btn-primary rounded-pill px-4 ms-auto restricted-feature" onclick="app.views.answerQuestions.openAnswerModal(${q.id})">Answer This</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        if (window.app.checkLawyerStatus) window.app.checkLawyerStatus();
    },

    openAnswerModal: function(id) {
        const q = app.storage.get(app.storage.keys.questions).find(item => item.id === id);
        if(!q) return;

        document.getElementById('q-title-modal').textContent = q.title;
        document.getElementById('q-body-modal').textContent = q.body;
        document.getElementById('answer-qid').value = q.id;
        document.getElementById('answer-text').value = "";

        new bootstrap.Modal(document.getElementById('answerModal')).show();
    },

    submitAnswer: function() {
        const qId = parseInt(document.getElementById('answer-qid').value);
        const content = document.getElementById('answer-text').value;

        if (!content) return app.storage.showToast("Please enter an answer.", "error");

        const currentUser = app.db.currentUser;
        let answers = app.storage.get(app.storage.keys.answers);
        const newId = answers.length > 0 ? Math.max(...answers.map(a => a.id)) + 1 : 1;

        answers.push({
            id: newId,
            questionId: qId,
            lawyerId: currentUser.id,
            lawyerName: currentUser.name,
            content: content,
            date: new Date().toISOString().split('T')[0]
        });

        app.storage.save(app.storage.keys.answers, answers);

        // Update question status
        let questions = app.storage.get(app.storage.keys.questions);
        const qIdx = questions.findIndex(q => q.id === qId);
        if (qIdx !== -1) {
            questions[qIdx].status = "Answered";
            app.storage.save(app.storage.keys.questions, questions);
        }

        app.storage.showToast("Answer submitted successfully!");
        bootstrap.Modal.getInstance(document.getElementById('answerModal')).hide();
        this.renderQuestions();
    }
};
