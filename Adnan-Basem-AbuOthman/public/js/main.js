document.addEventListener('DOMContentLoaded', function () {

    // 1. Navbar Scroll Effect
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled', 'shadow-sm', 'bg-white');
            } else {
                navbar.classList.remove('scrolled', 'shadow-sm', 'bg-white');
            }
        });
    }

    // 2. Mock Login/Signup Handling
    const loginForm = document.querySelector('form[action="profile.html"]');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = loginForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;

            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Logging in...';
            btn.disabled = true;

            setTimeout(() => {
                window.location.href = 'owner-dashboard.html'; // Redirect to dashboard for demo
            }, 1500);
        });
    }

    const signupForm = document.querySelector('form[action="login.html"]');
    if (signupForm) {
        signupForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = signupForm.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating Account...';
            btn.disabled = true;

            setTimeout(() => {
                window.location.href = 'login.html';
            }, 1500);
        });
    }

    // 3. Apartment Filtering (Mock)
    const priceRange = document.getElementById('priceRange');
    if (priceRange) {
        priceRange.addEventListener('input', (e) => {
            // In a real app, this would filter the list
            console.log('Price limit:', e.target.value);
            // Just a visual output update if we had an output element
        });

        const filterBtn = document.querySelector('.sidebar-filters .btn-primary');
        if (filterBtn) {
            filterBtn.addEventListener('click', () => {
                filterBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Applying...';

                // Get selected filter values
                const genderMale = document.getElementById('genderMale').checked;
                const genderFemale = document.getElementById('genderFemale').checked;

                setTimeout(() => {
                    filterBtn.innerHTML = 'Apply Filters';

                    const cards = document.querySelectorAll('.apartment-card-vertical');
                    let visibleCount = 0;

                    cards.forEach(card => {
                        const cardGender = card.getAttribute('data-gender');
                        let showCard = true;

                        // Gender Filter Logic
                        // If at least one gender is checked, we filter. If none, we show all (or assume show all).
                        if (genderMale || genderFemale) {
                            const matchMale = genderMale && cardGender === 'male';
                            const matchFemale = genderFemale && cardGender === 'female';

                            if (!matchMale && !matchFemale) {
                                showCard = false;
                            }
                        }

                        if (showCard) {
                            card.style.display = 'block';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Update result count
                    const countSpan = document.querySelector('.col-lg-9 .d-flex span.text-muted');
                    if (countSpan) {
                        countSpan.innerText = `Showing ${visibleCount} results`;
                    }

                }, 500);
            });
        }
    }

    // 4. Contact Form Handler
    const contactForms = document.querySelectorAll('footer form, .contact-form');
    contactForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerText;

            btn.innerText = 'Sending...';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerText = 'Message Sent!';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-success');
                form.reset();

                setTimeout(() => {
                    btn.innerText = originalText;
                    btn.disabled = false;
                    btn.classList.add('btn-primary');
                    btn.classList.remove('btn-success');
                }, 3000);
            }, 1500);
        });
    });

    // 5. Profile Save Handler
    const profileForm = document.querySelector('.profile-form-card form');
    // if (profileForm) {
    //     profileForm.addEventListener('submit', (e) => {
    //         e.preventDefault();
    //         const btn = profileForm.querySelector('button[type="submit"]');
    //         btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

    //         setTimeout(() => {
    //             btn.innerHTML = 'Changes Saved!';
    //             btn.classList.replace('btn-primary', 'btn-success');

    //             setTimeout(() => {
    //                 btn.innerHTML = 'Save Changes';
    //                 btn.classList.replace('btn-success', 'btn-primary');
    //             }, 2000);
    //         }, 1000);
    //     });
    // }

});
