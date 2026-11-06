// public/js/app.js
// MountainTrip — Custom JavaScript

'use strict';

document.addEventListener('DOMContentLoaded', function () {

    // ════════════════════════════════════════════════════════
    // 1. AOS INIT
    // ════════════════════════════════════════════════════════
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 700,
            once: true,
            easing: 'ease-out-cubic',
            offset: 80,
        });
    }

    // ════════════════════════════════════════════════════════
    // 2. NAVBAR SCROLL EFFECT
    // ════════════════════════════════════════════════════════
    const navbar = document.getElementById('mainNavbar');
    if (navbar) {
        const handleScroll = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        };
        window.addEventListener('scroll', handleScroll, { passive: true });
    }

    // ════════════════════════════════════════════════════════
    // 3. AUTO DISMISS TOASTS
    // ════════════════════════════════════════════════════════
    document.querySelectorAll('.toast').forEach(function (toastEl) {
        setTimeout(function () {
            const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
            toast.hide();
        }, 4500);
    });

    // ════════════════════════════════════════════════════════
    // 4. SMOOTH ANCHOR SCROLL
    // ════════════════════════════════════════════════════════
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const offset = 80; // tinggi navbar
                const top = target.getBoundingClientRect().top + window.scrollY - offset;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        });
    });

    // ════════════════════════════════════════════════════════
    // 5. IMAGE PREVIEW UPLOAD (Admin Form)
    // ════════════════════════════════════════════════════════
    const imageInput = document.getElementById('imageInput');
    if (imageInput) {
        imageInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview  = document.getElementById('imagePreview');
                    const wrapper  = document.getElementById('previewWrapper');
                    if (preview && wrapper) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                        wrapper.classList.add('d-none');
                    }
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // ════════════════════════════════════════════════════════
    // 6. CHECKOUT: REAL-TIME HARGA KALKULASI
    // ════════════════════════════════════════════════════════
    const participantInput = document.getElementById('participantCount');
    if (participantInput) {
        const pricePerPerson = Number(participantInput.dataset.price) || 0;
        const totalPriceEl   = document.getElementById('totalPrice');
        const displayCountEl = document.getElementById('displayCount');

        const updatePrice = () => {
            const count     = parseInt(participantInput.value) || 1;
            const total     = count * pricePerPerson;
            const formatted = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            if (totalPriceEl)   totalPriceEl.textContent   = formatted;
            if (displayCountEl) displayCountEl.textContent = count + ' orang';
        };

        participantInput.addEventListener('input', updatePrice);
        updatePrice();
    }

    // ════════════════════════════════════════════════════════
    // 7. CONFIRM DELETE
    // ════════════════════════════════════════════════════════
    document.querySelectorAll('[data-confirm]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            const msg = this.dataset.confirm || 'Apakah Anda yakin?';
            if (!window.confirm(msg)) {
                e.preventDefault();
            }
        });
    });

    // ════════════════════════════════════════════════════════
    // 8. COUNTER ANIMATION (untuk stats angka)
    // ════════════════════════════════════════════════════════
    const counters = document.querySelectorAll('[data-count]');
    if (counters.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el     = entry.target;
                    const target = parseInt(el.dataset.count);
                    const suffix = el.dataset.suffix || '';
                    let current  = 0;
                    const step   = Math.ceil(target / 60);
                    const timer  = setInterval(() => {
                        current += step;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        el.textContent = current.toLocaleString('id-ID') + suffix;
                    }, 20);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(el => observer.observe(el));
    }

    // ════════════════════════════════════════════════════════
    // 9. BACK TO TOP BUTTON
    // ════════════════════════════════════════════════════════
    const backToTopBtn = document.getElementById('backToTop');
    if (backToTopBtn) {
        window.addEventListener('scroll', function () {
            backToTopBtn.classList.toggle('show', window.scrollY > 400);
        }, { passive: true });
        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ════════════════════════════════════════════════════════
    // 10. FORM LOADING STATE (cegah double submit)
    // ════════════════════════════════════════════════════════
    document.querySelectorAll('form[data-loading]').forEach(function (form) {
        form.addEventListener('submit', function () {
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            }
        });
    });
    // ════════════════════════════════════════════════════════
// 11. LAZY IMAGE LOAD — Tambah class 'loaded' saat siap
// ════════════════════════════════════════════════════════
document.querySelectorAll('img[loading="lazy"]').forEach(function (img) {
    if (img.complete) {
        img.classList.add('loaded');
    } else {
        img.addEventListener('load', function () {
            img.classList.add('loaded');
        });
    }
});

});