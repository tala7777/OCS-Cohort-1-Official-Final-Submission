/**
 * ============================================
 * SHARED JAVASCRIPT - Legal Q&A Platform
 * Common utilities and helpers
 * ============================================
 */

// Toast notification system
const Toast = {
    show(message, type = 'info', duration = 3000) {
        const container = this.getContainer();
        const toast = this.createToast(message, type);
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    },
    
    getContainer() {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        return container;
    },
    
    createToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            info: 'fa-info-circle',
            warning: 'fa-exclamation-triangle'
        };
        
        const titles = {
            success: 'Success',
            error: 'Error',
            info: 'Info',
            warning: 'Warning'
        };
        
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas ${icons[type] || icons.info}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${titles[type] || titles.info}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        return toast;
    },
    
    success(message) {
        this.show(message, 'success');
    },
    
    error(message) {
        this.show(message, 'error');
    },
    
    info(message) {
        this.show(message, 'info');
    },
    
    warning(message) {
        this.show(message, 'warning');
    }
};

// Modal management
const Modal = {
    open(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    },
    
    close(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    },
    
    closeAll() {
        document.querySelectorAll('.modal.show').forEach(modal => {
            modal.classList.remove('show');
        });
        document.body.style.overflow = '';
    }
};

// Confirmation dialog
function confirmAction(message, onConfirm) {
    if (confirm(message)) {
        onConfirm();
    }
}

// Demo action handler
function demoAction(actionName) {
    Toast.info(`Demo Mode: "${actionName}" will be connected to PHP backend later.`);
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Format number with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// Debounce function for search inputs
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize modal close handlers
document.addEventListener('DOMContentLoaded', () => {
    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                Modal.close(modal.id);
            }
        });
    });
    
    // Close modal buttons
    document.querySelectorAll('.modal-close, [data-modal-close]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const modal = e.target.closest('.modal');
            if (modal) {
                Modal.close(modal.id);
            }
        });
    });
    
    // ESC key to close modals
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            Modal.closeAll();
        }
    });
});

// Export for use in other scripts
window.Toast = Toast;
window.Modal = Modal;
window.confirmAction = confirmAction;
window.demoAction = demoAction;
window.formatDate = formatDate;
window.formatNumber = formatNumber;
window.debounce = debounce;
