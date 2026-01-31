/**
 * ============================================
 * ADMIN UI JAVASCRIPT
 * Client-side filtering, search, sort, and UI interactions
 * NO DATA PERSISTENCE - UI only
 * ============================================
 */

// ============================================
// TABLE FILTERING & SEARCH
// ============================================

class TableFilter {
    constructor(tableId) {
        this.table = document.getElementById(tableId);
        this.tbody = this.table?.querySelector('tbody');
        this.rows = this.tbody ? Array.from(this.tbody.querySelectorAll('tr')) : [];
    }
    
    search(query) {
        if (!this.tbody) return;
        
        const searchTerm = query.toLowerCase().trim();
        
        this.rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
        
        this.updateEmptyState();
    }
    
    filterByAttribute(attribute, value) {
        if (!this.tbody) return;
        
        this.rows.forEach(row => {
            if (!value) {
                row.style.display = '';
            } else {
                const rowValue = row.getAttribute(`data-${attribute}`);
                row.style.display = rowValue === value ? '' : 'none';
            }
        });
        
        this.updateEmptyState();
    }
    
    sortBy(attribute, order = 'asc') {
        if (!this.tbody) return;
        
        const sortedRows = [...this.rows].sort((a, b) => {
            const aVal = a.getAttribute(`data-${attribute}`) || '';
            const bVal = b.getAttribute(`data-${attribute}`) || '';
            
            // Try numeric comparison first
            const aNum = parseFloat(aVal);
            const bNum = parseFloat(bVal);
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return order === 'asc' ? aNum - bNum : bNum - aNum;
            }
            
            // String comparison
            return order === 'asc' 
                ? aVal.localeCompare(bVal)
                : bVal.localeCompare(aVal);
        });
        
        sortedRows.forEach(row => this.tbody.appendChild(row));
    }
    
    updateEmptyState() {
        const visibleRows = this.rows.filter(row => row.style.display !== 'none');
        
        let emptyRow = this.tbody.querySelector('.empty-row');
        
        if (visibleRows.length === 0) {
            if (!emptyRow) {
                const colCount = this.rows[0]?.cells.length || 1;
                emptyRow = document.createElement('tr');
                emptyRow.className = 'empty-row';
                emptyRow.innerHTML = `
                    <td colspan="${colCount}" class="empty-state">
                        <i class="fas fa-search"></i>
                        <h4>No results found</h4>
                        <p>Try adjusting your filters or search query</p>
                    </td>
                `;
                this.tbody.appendChild(emptyRow);
            }
        } else {
            if (emptyRow) {
                emptyRow.remove();
            }
        }
    }
    
    reset() {
        this.rows.forEach(row => row.style.display = '');
        const emptyRow = this.tbody?.querySelector('.empty-row');
        if (emptyRow) emptyRow.remove();
    }
}

// ============================================
// FORM HANDLERS
// ============================================

function populateEditForm(formId, data) {
    const form = document.getElementById(formId);
    if (!form) return;
    
    Object.keys(data).forEach(key => {
        const input = form.querySelector(`[name="${key}"]`);
        if (input) {
            input.value = data[key];
        }
    });
}

function getFormData(formId) {
    const form = document.getElementById(formId);
    if (!form) return {};
    
    const formData = new FormData(form);
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    return data;
}

function resetForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
    }
}

// ============================================
// SIDEBAR TOGGLE (Mobile)
// ============================================

function toggleSidebar() {
    const sidebar = document.querySelector('.admin-sidebar');
    if (sidebar) {
        sidebar.classList.toggle('mobile-open');
    }
}

// ============================================
// ACTIVE NAVIGATION
// ============================================

function setActiveNav() {
    const currentPage = window.location.pathname.split('/').pop();
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href === currentPage) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

// ============================================
// INITIALIZE ON PAGE LOAD
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    setActiveNav();
    
    // Mobile menu toggle
    const menuToggle = document.getElementById('mobile-menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        const sidebar = document.querySelector('.admin-sidebar');
        const menuToggle = document.getElementById('mobile-menu-toggle');
        
        if (sidebar && sidebar.classList.contains('mobile-open')) {
            if (!sidebar.contains(e.target) && e.target !== menuToggle) {
                sidebar.classList.remove('mobile-open');
            }
        }
    });
});

// ============================================
// EXPORT FOR GLOBAL USE
// ============================================

window.TableFilter = TableFilter;
window.populateEditForm = populateEditForm;
window.getFormData = getFormData;
window.resetForm = resetForm;
window.toggleSidebar = toggleSidebar;
