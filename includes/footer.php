<footer class="site-footer">
        <div class="container footer-content">
            <p>&copy; <?= date('Y'); ?> Bala. Built for organic growth & high conversion.</p>
            <div class="footer-links">
                <a href="https://github.com/Balanandawagle" target="_blank" rel="noopener noreferrer" title="GitHub" class="footer-social-link">
                    <i class="fa-brands fa-github"></i> GitHub
                </a>
                <a href="https://www.instagram.com/balathegreat_060/" target="_blank" rel="noopener noreferrer" title="Instagram" class="footer-social-link">
                    <i class="fa-brands fa-instagram"></i> Instagram
                </a>
                <a href="https://www.facebook.com/om.wagle.58/" target="_blank" rel="noopener noreferrer" title="Facebook" class="footer-social-link">
                    <i class="fa-brands fa-facebook"></i> Facebook
                </a>
                <a href="https://www.linkedin.com/in/balanandawagle" target="_blank" rel="noopener noreferrer" title="LinkedIn" class="footer-social-link">
                    <i class="fa-brands fa-linkedin"></i> LinkedIn
                </a>
                <a href="mailto:wagleom@gmail.com" title="Email Me" class="footer-social-link">
                    <i class="fa-solid fa-envelope"></i> Email
                </a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- 1. Instant Theme Switcher ---
            const toggleBtn = document.getElementById('themeToggle');
            const root = document.documentElement;
            const icon = toggleBtn ? toggleBtn.querySelector('.toggle-icon') : null;

            function syncThemeIcon() {
                const current = root.getAttribute('data-theme') || 'dark';
                if (icon) {
                    icon.textContent = current === 'dark' ? '☀️' : '🌙';
                }
            }
            syncThemeIcon();

            if (toggleBtn) {
                toggleBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const current = root.getAttribute('data-theme') || 'dark';
                    const next = current === 'dark' ? 'light' : 'dark';
                    root.setAttribute('data-theme', next);
                    localStorage.setItem('portfolio-theme', next);
                    syncThemeIcon();
                });
            }

            // --- 2. Mobile Hamburger Menu Toggle ---
            const mobileBtn = document.getElementById('mobileMenuBtn');
            const navMenu = document.getElementById('navLinks');
            const menuIcon = mobileBtn ? mobileBtn.querySelector('.menu-icon') : null;

            if (mobileBtn && navMenu) {
                mobileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isOpen = navMenu.classList.toggle('nav-open');
                    if (menuIcon) {
                        menuIcon.className = isOpen ? 'fa-solid fa-xmark menu-icon' : 'fa-solid fa-bars menu-icon';
                    }
                });

                // Auto-close menu when clicking any nav link
                navMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        navMenu.classList.remove('nav-open');
                        if (menuIcon) menuIcon.className = 'fa-solid fa-bars menu-icon';
                    });
                });

                // Close menu when clicking outside
                document.addEventListener('click', (e) => {
                    if (!navMenu.contains(e.target) && !mobileBtn.contains(e.target)) {
                        navMenu.classList.remove('nav-open');
                        if (menuIcon) menuIcon.className = 'fa-solid fa-bars menu-icon';
                    }
                });
            }

            // --- 3. Top Scroll Progress Indicator ---
            window.addEventListener('scroll', () => {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = height > 0 ? (winScroll / height) * 100 : 0;
                const bar = document.getElementById('scrollProgressBar');
                if (bar) bar.style.width = scrolled + '%';
            });

            // --- 4. Kinetic Number Counter ---
            function animateCounter(el) {
                const target = parseInt(el.getAttribute('data-target'), 10);
                const suffix = el.getAttribute('data-suffix') || '';
                const duration = 1400;
                const stepTime = 20;
                const totalSteps = duration / stepTime;
                const stepIncrement = target / totalSteps;
                let current = 0;

                const timer = setInterval(() => {
                    current += stepIncrement;
                    if (current >= target) {
                        el.textContent = target.toLocaleString() + suffix;
                        clearInterval(timer);
                    } else {
                        el.textContent = Math.floor(current).toLocaleString() + suffix;
                    }
                }, stepTime);
            }

            // --- 5. Scroll Reveal Intersection Observer ---
            const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
            const scrollObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');

                        const counters = entry.target.querySelectorAll('.counter');
                        counters.forEach(counter => {
                            if (!counter.classList.contains('counted')) {
                                counter.classList.add('counted');
                                animateCounter(counter);
                            }
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: "0px 0px -30px 0px"
            });

            revealElements.forEach(el => scrollObserver.observe(el));
        });
    </script>
</body>
</html>