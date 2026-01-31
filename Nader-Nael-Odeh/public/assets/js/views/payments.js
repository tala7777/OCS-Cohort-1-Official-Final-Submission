window.app = window.app || {};
window.app.views = window.app.views || {};

window.app.views.payments = {
    init: function() {
        const payments = window.app.db.payments;
        const tbody = document.querySelector("#paymentsTable tbody");

        const getStatusBadge = (status) => {
            let color = 'secondary';
            if(['Completed'].includes(status)) color = 'success';
            if(['Pending'].includes(status)) color = 'warning';
            if(['Failed'].includes(status)) color = 'danger';
            return `<span class="badge badge-soft-${color} text-dark">${status}</span>`;
        };

        if(tbody) {
            tbody.innerHTML = payments.map(p => `
                <tr>
                    <td><span class="font-monospace">${p.id}</span></td>
                    <td>${p.user}</td>
                    <td>${p.lawyer}</td>
                    <td>${p.amount}</td>
                    <td>${getStatusBadge(p.status)}</td>
                    <td>${p.date}</td>
                </tr>
            `).join('');
        }
    }
};
