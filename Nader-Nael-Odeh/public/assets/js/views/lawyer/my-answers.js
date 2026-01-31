window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.myAnswers = {
    init: function() {
        this.renderTable();
        this.initEvents();
    },

    initEvents: function() {
        const saveBtn = document.getElementById('saveEditAnswerBtn');
        if(saveBtn) saveBtn.onclick = () => this.saveEdit();
    },

    renderTable: function() {
        const currentUser = app.db.currentUser;
        const questions = app.storage.get(app.storage.keys.questions);
        const answers = app.storage.get(app.storage.keys.answers);
        const tbody = document.querySelector("#myAnswersTable tbody");
        if (!tbody) return;

        const myAnswers = answers.filter(a => a.lawyerId === currentUser.id);

        if (myAnswers.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-muted small">You haven\'t posted any answers yet.</td></tr>';
            return;
        }

        tbody.innerHTML = myAnswers.map(a => {
            const q = questions.find(item => item.id === a.questionId) || { title: "Deleted Question", category: "N/A" };
            return `
                <tr>
                    <td style="max-width: 250px;"><a href="../public/question-details.html?id=${a.questionId}" target="_blank" class="fw-bold text-dark text-decoration-none">${q.title}</a></td>
                    <td><span class="badge bg-soft-primary text-primary">${q.category}</span></td>
                    <td class="text-muted small">${a.content.substring(0, 80)}...</td>
                    <td>${a.date}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary rounded-circle me-1" onclick="app.views.myAnswers.openEditModal(${a.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-outline-danger rounded-circle" onclick="app.views.myAnswers.handleDelete(${a.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        }).join('');
    },

    openEditModal: function(id) {
        const answers = app.storage.get(app.storage.keys.answers);
        const a = answers.find(item => item.id === id);
        if (!a) return;

        document.getElementById('editAnswerId').value = a.id;
        document.getElementById('editAnswerText').value = a.content;
        
        const modal = new bootstrap.Modal(document.getElementById('editAnswerModal'));
        modal.show();
    },

    saveEdit: function() {
        const id = parseInt(document.getElementById('editAnswerId').value);
        const content = document.getElementById('editAnswerText').value;

        if (!content) return app.storage.showToast("Answer cannot be empty", "error");

        let answers = app.storage.get(app.storage.keys.answers);
        const index = answers.findIndex(a => a.id === id);
        if (index === -1) return;

        answers[index].content = content;
        answers[index].date = new Date().toISOString().split('T')[0]; // Update date on edit

        app.storage.save(app.storage.keys.answers, answers);
        app.storage.showToast("Answer updated successfully");
        bootstrap.Modal.getInstance(document.getElementById('editAnswerModal')).hide();
        this.renderTable();
    },

    handleDelete: function(id) {
        app.storage.confirmAction("Delete Answer", "Are you sure you want to delete your response? This cannot be undone.", () => {
            let answers = app.storage.get(app.storage.keys.answers);
            const filtered = answers.filter(a => a.id !== id);
            app.storage.save(app.storage.keys.answers, filtered);
            app.storage.showToast("Answer deleted successfully.");
            this.renderTable();
        });
    }
};
