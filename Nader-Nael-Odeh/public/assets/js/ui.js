/* ==========================================
   ROLE & VIEW MODE MANAGEMENT (DEMO ONLY)
   ========================================== */

const roles = {
    GUEST: 'guest',
    USER: 'user',
    LAWYER_PENDING: 'lawyer-pending',
    LAWYER_APPROVED: 'lawyer-approved'
};

// Global state
window.currentDemoRole = sessionStorage.getItem('demoRole') || roles.GUEST;

function updateUIForRole() {
    const selector = document.getElementById('roleSelector');
    // If selector exists, sync it with current state (handles page reloads)
    if (selector && selector.value !== window.currentDemoRole) {
        selector.value = window.currentDemoRole;
    }

    const role = window.currentDemoRole;
    console.log('Updating UI for role:', role); // Debug

    // 1. Reset Visibility
    // Hide everything first
    const guestEls = document.querySelectorAll('.guest-only');
    const loggedInEls = document.querySelectorAll('.logged-in-only'); // Generic logged in
    const userEls = document.querySelectorAll('.user-only');
    const lawyerEls = document.querySelectorAll('.lawyer-only'); // Approved lawyers
    
    guestEls.forEach(el => el.classList.add('d-none'));
    loggedInEls.forEach(el => el.classList.add('d-none'));
    userEls.forEach(el => el.classList.add('d-none'));
    lawyerEls.forEach(el => el.classList.add('d-none'));
    
    // Banner
    const banner = document.getElementById('pendingLawyerBanner');
    if (banner) banner.classList.add('d-none');

    // 2. Apply Visibility based on Role
    if (role === roles.GUEST) {
        guestEls.forEach(el => el.classList.remove('d-none'));
    } else {
        // Any logged in user
        loggedInEls.forEach(el => el.classList.remove('d-none'));
        
        // Update User Name in Menu
        const nameDisplay = document.getElementById('userMenuName');
        if (nameDisplay) {
            if (role === roles.USER) nameDisplay.textContent = 'Indiv. User';
            else if (role === roles.LAWYER_PENDING) nameDisplay.textContent = 'Atty. Pending';
            else if (role === roles.LAWYER_APPROVED) nameDisplay.textContent = 'Atty. Marcus';
        }

        if (role === roles.USER) {
            userEls.forEach(el => el.classList.remove('d-none'));
        } 
        else if (role === roles.LAWYER_PENDING) {
            // Show banner
            if (banner) banner.classList.remove('d-none');
            // Pending lawyers don't get 'lawyer-only' features yet (usually)
            // But they are logged in.
        } 
        else if (role === roles.LAWYER_APPROVED) {
            lawyerEls.forEach(el => el.classList.remove('d-none'));
        }
    }
}

function handleRoleChange(e) {
    window.currentDemoRole = e.target.value;
    sessionStorage.setItem('demoRole', window.currentDemoRole);
    updateUIForRole();
}

function handleLogout() {
    window.currentDemoRole = roles.GUEST;
    sessionStorage.setItem('demoRole', roles.GUEST);
    // Reload to plain index or stay on page? Stay on page and update UI is smoother.
    updateUIForRole();
    // Special case: if on a protected page, maybe redirect? For now, just UI update.
    if(document.getElementById('roleSelector')) {
        document.getElementById('roleSelector').value = roles.GUEST;
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
    const selector = document.getElementById('roleSelector');
    if (selector) {
        selector.addEventListener('change', handleRoleChange);
        // Set initial value
        selector.value = window.currentDemoRole;
    }
    updateUIForRole();
});

// Demo Actions
function handleDemoAction(action, context) {
    // Using the shared Toast if available, else alert
    if (typeof Toast !== 'undefined') {
        Toast.info(`DEMO ONLY: "${action}" for ${context} will be connected to backend later.`);
    } else {
        alert(`DEMO ONLY: The "${action}" action for ${context} will be connected to the PHP backend later.`);
    }
}

function confirmDeleteDemo(context) {
    if (confirm(`Are you sure you want to delete this ${context}? (Demo only, nothing will be deleted)`)) {
        handleDemoAction('Delete', context);
    }
}
