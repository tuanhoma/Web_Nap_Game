/**
 * Game Top-up Portal - JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });

    // Package card selection
    const packageCards = document.querySelectorAll('.package-card[data-package-id]');
    const packageInput = document.getElementById('selected_package_id');
    
    packageCards.forEach(function(card) {
        card.addEventListener('click', function() {
            // Remove selected from all
            packageCards.forEach(c => c.classList.remove('selected'));
            // Add selected to clicked
            this.classList.add('selected');
            // Set hidden input value
            if (packageInput) {
                packageInput.value = this.dataset.packageId;
            }
            // Enable submit button
            const submitBtn = document.getElementById('btn-confirm');
            if (submitBtn) {
                submitBtn.disabled = false;
            }
        });
    });

    // Format VND numbers
    const moneyElements = document.querySelectorAll('.format-money');
    moneyElements.forEach(function(el) {
        const amount = parseFloat(el.textContent);
        if (!isNaN(amount)) {
            el.textContent = new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
        }
    });

    // Animate elements on scroll
    const animateElements = document.querySelectorAll('.animate-on-scroll');
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    animateElements.forEach(function(el) {
        observer.observe(el);
    });

    // Confirm payment button loading state
    const paymentForm = document.getElementById('payment-form');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';
            }
        });
    }
});
