<?php
// Smart Footer - Shows detailed footer only on main page (index.php)
$current_page = basename($_SERVER['PHP_SELF']);
$is_home_page = ($current_page == 'index.php' || $current_page == '');
?>

<footer class="mt-auto py-4 border-top footer-custom-bg">
    <div class="container">
        
        <?php if ($is_home_page): ?>
            <!-- FULL DETAILED FOOTER (Only visible on Main / Index Page) -->
            <div class="row g-4 py-3">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-cube text-primary fs-4"></i>
                        <span class="fw-extrabold fs-5 footer-heading">NexusDigital</span>
                    </div>
                    <p class="small footer-text mb-3">Enterprise Web Architecture & Custom PHP/MySQL Software Engineering Platform.</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle"><i class="fa-brands fa-github"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle"><i class="fa-solid fa-globe"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold mb-3 footer-heading">Quick Navigation</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li><a href="index.php" class="text-decoration-none footer-link">Home Page</a></li>
                        <li><a href="about.php" class="text-decoration-none footer-link">About Us</a></li>
                        <li><a href="services.php" class="text-decoration-none footer-link">Services Portfolio</a></li>
                        <li><a href="contact.php" class="text-decoration-none footer-link">Contact Support</a></li>
                        <li><a href="admin_login.php" class="text-decoration-none footer-link">Admin Portal</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-3">
                    <h6 class="fw-bold mb-3 footer-heading">Core Expertise</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0 footer-text">
                        <li><i class="fa-solid fa-chevron-right extra-small me-1 text-primary"></i> Full-Stack PHP Logic</li>
                        <li><i class="fa-solid fa-chevron-right extra-small me-1 text-primary"></i> Relational MySQL Schemas</li>
                        <li><i class="fa-solid fa-chevron-right extra-small me-1 text-primary"></i> OWASP Security Hardening</li>
                        <li><i class="fa-solid fa-chevron-right extra-small me-1 text-primary"></i> Admin CRUD Dashboards</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3 footer-heading">Headquarters</h6>
                    <p class="small footer-text mb-1"><i class="fa-solid fa-location-dot me-2 text-primary"></i> Zarghoon Road, Quetta, Pakistan</p>
                    <p class="small footer-text mb-1"><i class="fa-solid fa-envelope me-2 text-primary"></i> contact@nexusdigital.pk</p>
                    <p class="small footer-text mb-0"><i class="fa-solid fa-phone me-2 text-primary"></i> +92 (81) 283-9102</p>
                </div>
            </div>
            <hr class="my-3 footer-divider">
        <?php endif; ?>

        <!-- MINIMAL FOOTER STRIP (Appears on all sub-pages) -->
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between footer-text small">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> NexusDigital Systems. Enterprise SaaS Architecture. All Rights Reserved.</p>
            <div class="d-flex gap-3 mt-2 mt-sm-0">
                <a href="index.php" class="text-decoration-none footer-link">Home</a>
                <a href="services.php" class="text-decoration-none footer-link">Services</a>
                <a href="contact.php" class="text-decoration-none footer-link">Contact</a>
            </div>
        </div>
    </div>
</footer>

<!-- DYNAMIC THEME FOOTER STYLING -->
<style>
    .footer-custom-bg {
        background-color: var(--footer-bg, #f0f4f8) !important;
        border-top: 1px solid var(--footer-border, #e2e8f0) !important;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .footer-heading {
        color: var(--text-heading, #1e293b) !important;
    }

    .footer-text {
        color: var(--text-muted, #64748b) !important;
    }

    .footer-link {
        color: var(--text-muted, #64748b) !important;
        transition: color 0.2s ease;
    }

    .footer-link:hover {
        color: var(--brand-primary, #2563eb) !important;
    }

    .footer-divider {
        border-color: var(--footer-border, rgba(0,0,0,0.08)) !important;
        opacity: 1;
    }

    /* Dark Mode Theme Support across all selectors */
    [data-theme="dark"] .footer-custom-bg,
    [data-bs-theme="dark"] .footer-custom-bg,
    html[data-theme="dark"] .footer-custom-bg,
    body.dark-mode .footer-custom-bg {
        --footer-bg: #0b0f19;
        --footer-border: #1f2937;
        --text-heading: #f8fafc;
        --text-muted: #94a3b8;
    }

    [data-theme="dark"] .footer-divider,
    [data-bs-theme="dark"] .footer-divider,
    html[data-theme="dark"] .footer-divider,
    body.dark-mode .footer-divider {
        border-color: #1f2937 !important;
    }
</style>

<!-- REQUIRED JAVASCRIPT FOR BOOTSTRAP TOGGLE MENU & DARK THEME -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
