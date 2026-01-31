window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.questions = {
    init: function() {
        this.populateFilters();
        this.renderTable();
        this.initEvents();
    },

    populateFilters: function() {
        const select = document.getElementById('category-filter');
        if (!select) return;
        
        // Use unified categories
        const cats = app.storage.get(app.storage.keys.categories);
        cats.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.name;
            opt.textContent = c.name + (c.is_active ? '' : ' (Inactive)');
            select.appendChild(opt);
        });
    },

    initEvents: function() {
        const searchInput = document.getElementById('search-questions');
        const catFilter = document.getElementById('category-filter');
        const statusFilter = document.getElementById('status-filter');
        
        if (searchInput) searchInput.oninput = () => this.renderTable();
        if (catFilter) catFilter.onchange = () => this.renderTable();
        if (statusFilter) statusFilter.onchange = () => this.renderTable();
    },

    renderTable: function() {
        const questions = app.storage.get(app.storage.keys.questions);
        const allAnswers = app.storage.get(app.storage.keys.answers);
        
        const searchInput = document.getElementById('search-questions');
        const catFilter = document.getElementById('category-filter');
        const statusFilter = document.getElementById('status-filter');
        
        const search = searchInput ? searchInput.value.toLowerCase() : "";
        const category = catFilter ? catFilter.value : "";
        const status = statusFilter ? statusFilter.value : "";
        
        const tbody = document.querySelector("#questionsTable tbody");
        if (!tbody) return;

        let filtered = questions.filter(q => {
            const matchesSearch = q.title.toLowerCase().includes(search) || q.askedBy.toLowerCase().includes(search);
            const matchesCat = !category || q.category === category;
            const matchesStatus = !status || q.status === status;
            return matchesSearch && matchesCat && matchesStatus;
        });

        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">No questions found.</td></tr>';
            return;
        }

        tbody.innerHTML = filtered.map(q => {
            const qAnswers = allAnswers.filter(a => a.questionId === q.id);
            return `
                <tr>
                    <td><span class="fw-bold text-dark">${q.title}</span></td>
                    <td>${q.askedBy}</td>
                    <td>${app.storage.getCategoryBadge(q.category)}</td>
                    <td><span class="badge ${q.status === 'Open' ? 'bg-soft-warning text-warning' : 'bg-soft-success text-success'}">${q.status}</span></td>
                    <td><i class="fas fa-comment-dots text-muted me-1"></i> ${qAnswers.length}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="app.views.questions.viewAnswers(${q.id})">View</button>
                        <button class="btn btn-sm btn-outline-danger rounded-circle ms-1" onclick="app.views.questions.handleDelete(${q.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        }).join('');
    },
    
    viewAnswers: function(id) {
        const questions = app.storage.get(app.storage.keys.questions);
        const q = questions.find(item => item.id === id);
        if(!q) return;

        const allAnswers = app.storage.get(app.storage.keys.answers);
        const qAnswers = allAnswers.filter(a => a.questionId === id);
        
        const container = document.getElementById('modalAnswersBody');
        if (!container) return;

        document.getElementById('q-title-display').textContent = q.title;

        if (qAnswers.length === 0) {
            container.innerHTML = '<div class="text-center py-4 text-muted">No answers found for this question yet.</div>';
        } else {
            container.innerHTML = qAnswers.map(a => `
                <div class="card border-0 bg-light mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <span class="fw-bold me-2 text-dark">${a.lawyerName}</span>
                            <small class="text-muted ms-auto">${a.date}</small>
                        </div>
                        <p class="mb-0 small">${a.content}</p>
                    </div>
                </div>
            `).join('');
        }

        const modal = new bootstrap.Modal(document.getElementById('answersModal'));
        modal.show();
    },

    handleDelete: function(id) {
        const q = app.storage.get(app.storage.keys.questions).find(item => item.id === id);
        if(!q) return;

        app.storage.confirmAction("Delete Question", 
            `Are you sure you want to delete "${q.title}"? This will also remove all its answers permanently.`, 
            () => {
                app.storage.deleteQuestionCascade(id);
                this.renderTable();
            }
        );
    }
};
