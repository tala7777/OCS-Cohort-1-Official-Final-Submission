/**
 * Components.js
 * Handles rendering of common layout elements (Sidebar, Navbar)
 * and initialization of Lucide icons.
 */

const AppComponents = {
    renderSidebar: (role, activePage) => {
        const sidebarContainer = document.getElementById('sidebar-container');
        if (!sidebarContainer) return;

        const navItems = {
            admin: [
                { name: 'Dashboard', icon: 'layout-dashboard', href: '/dashboard' },
                { name: 'Classes', icon: 'school', href: '/admin/classes' },
                { name: 'Sections', icon: 'layers', href: '/admin/sections' },
                { name: 'Subjects', icon: 'book-open', href: '/admin/subjects' },
                { name: 'Users', icon: 'users', href: '/admin/users' },
            ],
            teacher: [
                { name: 'Dashboard', icon: 'layout-dashboard', href: '/dashboard' },
                { name: 'My Subjects', icon: 'book', href: '/teacher/subjects' },
                { name: 'Attendance', icon: 'calendar-check', href: '/teacher/attendance' },
                { name: 'Homework', icon: 'file-text', href: '/teacher/homework' },
                { name: 'Create Homework', icon: 'plus-square', href: '/teacher/homework/create' },
                { name: 'Grading', icon: 'check-circle', href: '/teacher/grading' },
            ],
            student: [
                { name: 'Dashboard', icon: 'layout-dashboard', href: '/student/dashboard' },
                { name: 'My Subjects', icon: 'book', href: '/student/subjects' },
                { name: 'Homework', icon: 'pencil-line', href: '/student/assignments' },
                { name: 'Attendance', icon: 'calendar-check-2', href: '/student/attendance' },
                { name: 'Grades', icon: 'book-open-check', href: '/student/grades' },
                { name: 'Profile', icon: 'user', href: '/profile' },
            ]
        };

        const currentNav = navItems[role] || [];

        const navHTML = currentNav.map(item => {
            const isActive = activePage === item.href || (activePage === 'dashboard' && item.href.includes('dashboard'));
            const activeClass = isActive ? 'active' : '';
            return `
                <a href="${item.href}" class="nav-item ${activeClass}">
                    <i data-lucide="${item.icon}"></i>
                    <span>${item.name}</span>
                </a>
            `;
        }).join('');

        sidebarContainer.innerHTML = `
            <aside class="sidebar">
                <div class="sidebar-header">
                    <i data-lucide="graduation-cap" style="margin-right: 0.5rem; color: var(--primary);"></i>
                    EduManage
                </div>
                <nav class="sidebar-nav">
                    ${navHTML}
                </nav>
            </aside>
        `;
    },

    renderNavbar: (user) => {
        const navbarContainer = document.getElementById('navbar-container');
        if (!navbarContainer) return;

        navbarContainer.innerHTML = `
            <header class="navbar">
                <button class="btn btn-outline" id="sidebar-toggle" style="padding: 0.5rem;">
                   <i data-lucide="menu"></i>
                </button>
                <div class="flex items-center gap-md">
                    <span style="font-weight: 500;">${user.name}</span>
                    <div style="width: 32px; height: 32px; background-color: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                        ${user.name.charAt(0)}
                    </div>
                </div>
            </header>
        `;
    },

    init: (role, activePage, user = { name: 'User' }) => {
        AppComponents.renderSidebar(role, activePage);
        AppComponents.renderNavbar(user);

        // Initialize Icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Mobile Sidebar Toggle
        const toggleBtn = document.getElementById('sidebar-toggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const sidebar = document.querySelector('.sidebar');
                sidebar.classList.toggle('open');
            });
        }
    }
};
