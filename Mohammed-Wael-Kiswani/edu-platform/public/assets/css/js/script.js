// Script for interactive elements
document.addEventListener('DOMContentLoaded', function() {
    // Simulate user login state
    const loginBtn = document.getElementById('loginBtn');
    const logoutBtn = document.getElementById('logoutBtn');
    const userDropdown = document.getElementById('userDropdown');
    
    // Check if user is "logged in" (for demo purposes)
    // In a real app, this would come from backend/auth system
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    
    if (isLoggedIn) {
        // Update UI to show logged in state
        if (loginBtn) loginBtn.style.display = 'none';
        if (userDropdown) userDropdown.style.display = 'block';
    }
    
    // Logout functionality
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            localStorage.removeItem('isLoggedIn');
            window.location.href = 'index.html';
        });
    }
    
    // Login form submission (demo only)
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // In a real app, this would be an API call
            localStorage.setItem('isLoggedIn', 'true');
            window.location.href = 'profile.html';
        });
    }
    
    // Register form submission (demo only)
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // In a real app, this would be an API call
            localStorage.setItem('isLoggedIn', 'true');
            window.location.href = 'profile.html';
        });
    }
    
    // Payment form validation
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Simple validation
            const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
            const cvv = document.getElementById('cvv').value;
            
            if (cardNumber.length !== 16 || isNaN(cardNumber)) {
                alert('Please enter a valid 16-digit card number');
                return;
            }
            
            if (cvv.length !== 3 || isNaN(cvv)) {
                alert('Please enter a valid 3-digit CVV');
                return;
            }
            
            // In a real app, this would process payment
            alert('Payment successful! Redirecting to course...');
            window.location.href = 'course-details.html';
        });
    }
    
    // Format card number input
    const cardNumberInput = document.getElementById('cardNumber');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '').replace(/\D/g, '');
            let formattedValue = '';
            
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            
            e.target.value = formattedValue.substring(0, 19);
        });
    }
});
