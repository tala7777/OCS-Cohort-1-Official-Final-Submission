<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div id="sidebar-wrapper">
            <div class="sidebar-brand"><i class="fas fa-gavel"></i><span class="ms-2">ADMIN PANEL</span></div>
            <div class="list-group list-group-flush">
                <a href="dashboard" class="list-group-item list-group-item-action"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="lawyer-requests" class="list-group-item list-group-item-action"><i class="fas fa-user-clock"></i> Lawyer Requests</a>
                <a href="users" class="list-group-item list-group-item-action"><i class="fas fa-users"></i> Users</a>
                <a href="questions" class="list-group-item list-group-item-action"><i class="fas fa-question-circle"></i> Questions</a>
                <a href="articles" class="list-group-item list-group-item-action"><i class="fas fa-file-alt"></i> Articles</a>
                <!-- Hidden feature for now but kept for compatibility -->
                <a href="../public/index.html" class="list-group-item list-group-item-action mt-5 border-top"><i class="fas fa-home"></i> Back to Site</a>
            </div>
        </div>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand navbar-light navbar-custom">
                <div class="container-fluid">
                    <button class="btn btn-link text-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                    <div class="ms-3 d-flex align-items-center">
                        <select id="roleSwitcher" class="form-select form-select-sm" style="width: auto;">
                            <option value="Admin">Admin</option>
                            <option value="Lawyer">Lawyer</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                </div>
            </nav>

            <div class="container-fluid px-4 py-4">
                <h1 class="h3 mb-4 text-gray-800">Payment Transactions</h1>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="paymentsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Lawyer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/mock-data.js') }}"></script>
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script src="{{ asset('assets/js/views/payments.js') }}"></script>
    <script>document.addEventListener('DOMContentLoaded', () => { if(app.views.payments) app.views.payments.init(); });</script>
</body>
</html>

