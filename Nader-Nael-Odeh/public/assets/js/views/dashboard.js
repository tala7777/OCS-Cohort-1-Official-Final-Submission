window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.dashboard = {
    init: function() {
        this.renderStats();
        this.initChart();
    },

    renderStats: function() {
        const users = app.storage.get(app.storage.keys.users);
        const articles = app.storage.get(app.storage.keys.articles);
        const questions = app.storage.get(app.storage.keys.questions);
        const answers = app.storage.get(app.storage.keys.answers);
        const requests = app.storage.get(app.storage.keys.lawyerRequests);

        const container = document.getElementById("stats-container");
        if (!container) return;

        // Determine which role we're viewing stats for
        const currentUser = app.db.currentUser;
        let stats = [];

        if (currentUser.role === 'Admin') {
            stats = [
                { label: "Total Users", value: users.length, icon: "users", color: "primary" },
                { label: "Articles", value: articles.length, icon: "file-alt", color: "success" },
                { label: "Questions", value: questions.length, icon: "question-circle", color: "info" },
                { label: "Pending Requests", value: requests.filter(r => r.status === 'Pending').length, icon: "user-clock", color: "warning" }
            ];
        } else if (currentUser.role === 'Lawyer') {
            const myAnswers = answers.filter(a => a.lawyerId === currentUser.id).length;
            const myArticles = articles.filter(a => a.authorId === currentUser.id).length;
            stats = [
                { label: "My Answers", value: myAnswers, icon: "comments", color: "primary" },
                { label: "My Articles", value: myArticles, icon: "feather", color: "success" },
                { label: "Profile Views", value: "1.2k", icon: "eye", color: "info" },
                { label: "Engagement", value: "85%", icon: "chart-line", color: "warning" }
            ];
        } else {
            const myQuestions = questions.filter(q => q.authorId === currentUser.id);
            stats = [
                { label: "My Questions", value: myQuestions.length, icon: "question", color: "primary" },
                { label: "Answered", value: myQuestions.filter(q => q.status === 'Answered').length, icon: "check-circle", color: "success" },
                { label: "Saved Lawyers", value: 4, icon: "heart", color: "danger" },
                { label: "Followers", value: 12, icon: "user-friends", color: "info" }
            ];
        }

        container.innerHTML = stats.map(s => `
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 py-2 border-start border-${s.color} border-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="text-xs font-weight-bold text-${s.color} text-uppercase mb-1">${s.label}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${s.value}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-${s.icon} fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    },

    initChart: function() {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;
        
        // Simple mock chart
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                datasets: [{
                    label: "Activity",
                    data: [100, 150, 130, 200, 180, 250],
                    borderColor: "#0f2b46",
                    backgroundColor: "rgba(15, 43, 70, 0.05)",
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
};
