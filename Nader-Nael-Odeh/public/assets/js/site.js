/**
 * Public Site Main Logic
 * Using app.storage for data persistence
 */

window.site = {
    // Auth helpers
    checkAuth: function() {
        const user = localStorage.getItem('currentUser');
        if (user) {
            document.getElementById('auth-links').classList.add('d-none');
            document.getElementById('user-menu').classList.remove('d-none');
            const data = JSON.parse(user);
            document.getElementById('user-name-display').textContent = data.name;
            if (data.role === 'Admin') {
                const adminLink = document.getElementById('admin-link');
                if (adminLink) adminLink.classList.remove('d-none');
            }
        }
    },

    logout: function() {
        localStorage.removeItem('currentUser');
        location.reload();
    },

    // Populate Unified Categories Dropdowns
    populateCategories: function(selectId, onlyActive = true) {
        const select = document.getElementById(selectId);
        if (!select) return;
        
        // Remove existing except the first (placeholder)
        while (select.options.length > 1) select.remove(1);
        
        const cats = onlyActive ? app.storage.getActiveCategories() : app.storage.get(app.storage.keys.categories);
        cats.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.name;
            opt.textContent = c.name + (c.is_active ? '' : ' (Inactive)');
            select.appendChild(opt);
        });
    },

    // QUESTIONS FEED
    initFeed: function() {
        this.populateCategories('category-filter', false); // Allow filtering by inactive for historical content
        this.renderFeed();
        
        const catFilter = document.getElementById('category-filter');
        const searchInput = document.getElementById('search-questions');
        if (catFilter) catFilter.onchange = () => this.renderFeed();
        if (searchInput) searchInput.oninput = () => this.renderFeed();
    },

    renderFeed: function() {
        const questions = app.storage.get(app.storage.keys.questions);
        const answers = app.storage.get(app.storage.keys.answers);
        const categorySelect = document.getElementById('category-filter');
        const searchSelect = document.getElementById('search-questions');
        
        const category = categorySelect ? categorySelect.value : "";
        const search = searchSelect ? searchSelect.value.toLowerCase() : "";
        
        let filtered = questions.filter(q => {
            const matchesCat = !category || q.category === category;
            const matchesSearch = q.title.toLowerCase().includes(search) || q.body.toLowerCase().includes(search);
            return matchesCat && matchesSearch;
        });

        filtered.sort((a,b) => new Date(b.date) - new Date(a.date));

        const container = document.getElementById("questions-feed");
        if(!container) return;

        if (filtered.length === 0) {
            container.innerHTML = '<div class="text-center py-5 text-muted">No questions found.</div>';
            return;
        }

        container.innerHTML = filtered.map(q => {
            const qAnswers = answers.filter(a => a.questionId === q.id);
            return `
                <div class="card question-card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                             ${app.storage.getCategoryBadge(q.category)}
                             <small class="text-muted"><i class="fas fa-clock me-1"></i> ${q.date}</small>
                        </div>
                        <h5 class="card-title fw-bold">
                            <a href="question-details.html?id=${q.id}" class="text-decoration-none text-dark">${q.title}</a>
                        </h5>
                        <p class="text-muted small">${q.body.substring(0, 150)}...</p>
                        <div class="d-flex align-items-center mt-3 pt-3 border-top">
                            <small class="text-muted">By <strong>${q.askedBy}</strong></small>
                            <span class="ms-auto badge ${qAnswers.length > 0 ? 'badge-soft-success' : 'badge-soft-warning'}">
                                <i class="fas fa-comment-dots me-1"></i> ${qAnswers.length} Answers
                            </span>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    },

    // LAWYERS DIRECTORY
    initLawyers: function() {
        this.populateCategories('spec-filter', false);
        this.renderLawyers();
        const searchInput = document.getElementById('lawyer-search');
        const specFilter = document.getElementById('spec-filter');
        if (searchInput) searchInput.oninput = () => this.renderLawyers();
        if (specFilter) specFilter.onchange = () => this.renderLawyers();
    },

    renderLawyers: function() {
        const users = app.storage.get(app.storage.keys.users);
        const searchInput = document.getElementById('lawyer-search');
        const specSelect = document.getElementById('spec-filter');
        
        const search = searchInput ? searchInput.value.toLowerCase() : "";
        const spec = specSelect ? specSelect.value : "";
        
        const lawyers = users.filter(u => u.role === 'Lawyer' && u.status === 'Active');

        let filtered = lawyers.filter(l => {
            const matchesSearch = l.name.toLowerCase().includes(search) || (l.specialization && l.specialization.toLowerCase().includes(search));
            const matchesSpec = !spec || l.specialization === spec;
            return matchesSearch && matchesSpec;
        });

        const container = document.getElementById('lawyers-grid');
        if(!container) return;

        if (filtered.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 text-muted">No lawyers found.</div>';
            return;
        }

        container.innerHTML = filtered.map(l => `
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <img src="${l.avatar}" class="rounded-circle mx-auto mb-3 border p-1" width="100" height="100">
                    <h5 class="fw-bold mb-1">${l.name}</h5>
                    <div class="mb-3">${app.storage.getCategoryBadge(l.specialization || 'General Practice')}</div>
                    <p class="text-muted small mb-4">${l.bio ? l.bio.substring(0, 80) + '...' : 'Dedicated legal expert.'}</p>
                    <a href="lawyer-profile.html?id=${l.id}" class="btn btn-outline-primary rounded-pill px-4 btn-sm">View Profile</a>
                </div>
            </div>
        `).join('');
    },

    // BLOG
    initBlog: function() {
        this.populateCategories('blog-cat-filter', false);
        this.renderBlog();
        const searchInput = document.getElementById('blog-search');
        const catFilter = document.getElementById('blog-cat-filter');
        if (searchInput) searchInput.oninput = () => this.renderBlog();
        if (catFilter) catFilter.onchange = () => this.renderBlog();
    },

    renderBlog: function() {
        const articles = app.storage.get(app.storage.keys.articles);
        const searchInput = document.getElementById('blog-search');
        const catSelect = document.getElementById('blog-cat-filter');

        const search = searchInput ? searchInput.value.toLowerCase() : "";
        const cat = catSelect ? catSelect.value : "";

        let filtered = articles.filter(a => {
            const matchesSearch = a.title.toLowerCase().includes(search) || a.content.toLowerCase().includes(search);
            const matchesCat = !cat || a.category === cat;
            return matchesSearch && matchesCat;
        });

        filtered.sort((a,b) => new Date(b.date) - new Date(a.date));

        const container = document.getElementById('articles-feed');
        if(!container) return;

        if (filtered.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 text-muted">No articles found.</div>';
            return;
        }

        container.innerHTML = filtered.map(a => `
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            ${app.storage.getCategoryBadge(a.category)}
                            <small class="text-muted">${a.date}</small>
                        </div>
                        <h5 class="fw-bold mb-3"><a href="article-details.html?id=${a.id}" class="text-dark text-decoration-none">${a.title}</a></h5>
                        <p class="text-muted small">${a.content.substring(0, 120)}...</p>
                        <div class="d-flex align-items-center mt-3 pt-3 border-top">
                            <small class="text-muted">By <strong>${a.authorName}</strong></small>
                            <span class="ms-auto text-meta"><i class="fas fa-eye me-1"></i> ${a.views}</span>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }
};

window.site.checkAuth();
