<?php
// NexusDigital - Professional About Us Page
include('header.php'); 
?>

<!-- PAGE HERO HEADER SECTION -->
<section class="py-5 border-bottom" style="background: linear-gradient(135deg, var(--sec-light-bg) 0%, var(--sec-accent-bg) 100%);">
    <div class="container py-4 text-center">
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-info"></i> ABOUT OUR ENGINEERING FIRM
        </span>
        <h1 class="fw-extrabold display-5 mb-3" style="color: var(--text-heading);">Architecting High-Performance Digital Solutions</h1>
        <p class="mx-auto fs-6 leading-relaxed text-muted" style="max-width: 720px;">
            We engineer mission-critical PHP web applications, high-concurrency MySQL relational databases, and enterprise-grade software frameworks tailored for scalability and performance.
        </p>
    </div>
</section>

<div class="container py-5">

    <!-- ANNOUNCEMENT / MISSION BANNER -->
    <div class="card border-0 rounded-4 overflow-hidden mb-5 text-white shadow-lg p-4 p-md-5" style="background: var(--brand-gradient);">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8">
                <span class="badge bg-white bg-opacity-20 text-white mb-3 px-3 py-2 rounded-pill fw-bold">
                    <i class="fa-solid fa-microchip me-1"></i> Core Philosophy
                </span>
                <h2 class="fw-extrabold mb-3 display-6">Secure, Scalable &amp; Object-Oriented</h2>
                <p class="fs-6 opacity-90 mb-0 leading-relaxed">
                    At NexusDigital, software engineering is not just writing code—it is designing sustainable architectures. We focus on normalized database structures, OWASP security practices, clean modular logic, and intuitive administrative control systems.
                </p>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="p-4 rounded-circle bg-white bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 140px; height: 140px;">
                    <i class="fa-solid fa-cubes-stacked display-3 opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- CORE ENGINEERING PILLARS -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card h-100 p-4 border rounded-4 text-center" style="background: var(--card-bg); border-color: var(--card-border) !important; box-shadow: var(--card-shadow);">
                <div class="mx-auto mb-3 text-primary fs-2">
                    <i class="fa-solid fa-code"></i>
                </div>
                <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Clean Codebase</h6>
                <p class="small text-muted mb-0">Object-Oriented PHP 8.2 standards with clean separation of logic.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 p-4 border rounded-4 text-center" style="background: var(--card-bg); border-color: var(--card-border) !important; box-shadow: var(--card-shadow);">
                <div class="mx-auto mb-3 text-info fs-2">
                    <i class="fa-solid fa-database"></i>
                </div>
                <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Normalized DB</h6>
                <p class="small text-muted mb-0">3NF relational MySQL schemas with indexed foreign keys.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 p-4 border rounded-4 text-center" style="background: var(--card-bg); border-color: var(--card-border) !important; box-shadow: var(--card-shadow);">
                <div class="mx-auto mb-3 text-success fs-2">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h6 class="fw-bold mb-1" style="color: var(--text-heading);">OWASP Hardened</h6>
                <p class="small text-muted mb-0">Prepared statements, CSRF protection, and session security.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 p-4 border rounded-4 text-center" style="background: var(--card-bg); border-color: var(--card-border) !important; box-shadow: var(--card-shadow);">
                <div class="mx-auto mb-3 text-warning fs-2">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
                <h6 class="fw-bold mb-1" style="color: var(--text-heading);">High Concurrency</h6>
                <p class="small text-muted mb-0">Optimized query execution for high traffic environments.</p>
            </div>
        </div>
    </div>

    <!-- TECHNICAL STACK & CAPABILITIES GRID -->
    <div class="mb-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <span class="text-primary fw-bold text-uppercase small">OUR TECH STACK</span>
                <h3 class="fw-extrabold mb-0" style="color: var(--text-heading);">Enterprise Technology Capabilities</h3>
            </div>
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill small fw-bold">v2.4 Active Stack</span>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card card-tech h-100 p-4 border rounded-4 shadow-sm" style="background: var(--card-bg); border-color: var(--card-border) !important;">
                    <div class="tech-icon-box bg-primary bg-opacity-10 text-primary rounded-3 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-brands fa-php fs-2"></i>
                    </div>
                    <h5 class="fw-bold fs-6 mb-2" style="color: var(--text-heading);">Full-Stack Dynamic PHP</h5>
                    <p class="text-muted small mb-0">Dynamic routing, secure session logic, role-based access control (RBAC), and clean server-side request processing.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card card-tech h-100 p-4 border rounded-4 shadow-sm" style="background: var(--card-bg); border-color: var(--card-border) !important;">
                    <div class="tech-icon-box bg-info bg-opacity-10 text-info rounded-3 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-database fs-4"></i>
                    </div>
                    <h5 class="fw-bold fs-6 mb-2" style="color: var(--text-heading);">MySQL Relational Systems</h5>
                    <p class="text-muted small mb-0">Data normalization, relational integrity constraints, indexed search tables, and transaction safe processing.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card card-tech h-100 p-4 border rounded-4 shadow-sm" style="background: var(--card-bg); border-color: var(--card-border) !important;">
                    <div class="tech-icon-box bg-success bg-opacity-10 text-success rounded-3 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-sliders fs-4"></i>
                    </div>
                    <h5 class="fw-bold fs-6 mb-2" style="color: var(--text-heading);">Interactive Admin Panels</h5>
                    <p class="text-muted small mb-0">Full CRUD operations (Create, Read, Update, Delete) with image upload handlers and record management capabilities.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card card-tech h-100 p-4 border rounded-4 shadow-sm" style="background: var(--card-bg); border-color: var(--card-border) !important;">
                    <div class="tech-icon-box bg-warning bg-opacity-10 text-warning rounded-3 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-shield-halved fs-4"></i>
                    </div>
                    <h5 class="fw-bold fs-6 mb-2" style="color: var(--text-heading);">OWASP Security Hardening</h5>
                    <p class="text-muted small mb-0">Protection against SQL Injection via prepared statements, XSS prevention, and bcrypt password encryption.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card card-tech h-100 p-4 border rounded-4 shadow-sm" style="background: var(--card-bg); border-color: var(--card-border) !important;">
                    <div class="tech-icon-box bg-danger bg-opacity-10 text-danger rounded-3 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-mobile-screen fs-4"></i>
                    </div>
                    <h5 class="fw-bold fs-6 mb-2" style="color: var(--text-heading);">Responsive Mobile UX</h5>
                    <p class="text-muted small mb-0">Bootstrap 5 fluid grids engineered for high performance on smartphone, tablet, and desktop viewports.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card card-tech h-100 p-4 border rounded-4 shadow-sm" style="background: var(--card-bg); border-color: var(--card-border) !important;">
                    <div class="tech-icon-box bg-secondary bg-opacity-10 text-secondary rounded-3 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-server fs-4"></i>
                    </div>
                    <h5 class="fw-bold fs-6 mb-2" style="color: var(--text-heading);">Local &amp; Cloud Deployment</h5>
                    <p class="text-muted small mb-0">Optimized for KSWEB local environments, Apache server configurations, and cloud hostings.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- DEVELOPMENT METHODOLOGY ROADMAP -->
    <div class="p-4 p-md-5 rounded-4 border mb-5" style="background: var(--sec-light-bg); border-color: var(--card-border) !important;">
        <div class="text-center mb-4">
            <span class="text-primary fw-bold text-uppercase small">OUR WORKFLOW</span>
            <h3 class="fw-extrabold" style="color: var(--text-heading);">Engineering Lifecycle</h3>
        </div>

        <div class="row g-4">
            <div class="col-6 col-md-3 text-center">
                <div class="fw-extrabold fs-3 text-primary mb-2">01</div>
                <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Schema Design</h6>
                <p class="small text-muted mb-0">Defining relational structures &amp; tables.</p>
            </div>
            <div class="col-6 col-md-3 text-center">
                <div class="fw-extrabold fs-3 text-primary mb-2">02</div>
                <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Logic &amp; CRUD</h6>
                <p class="small text-muted mb-0">Developing OOP backend operations.</p>
            </div>
            <div class="col-6 col-md-3 text-center">
                <div class="fw-extrabold fs-3 text-primary mb-2">03</div>
                <h6 class="fw-bold mb-1" style="color: var(--text-heading);">UI Integration</h6>
                <p class="small text-muted mb-0">Crafting responsive mobile interfaces.</p>
            </div>
            <div class="col-6 col-md-3 text-center">
                <div class="fw-extrabold fs-3 text-primary mb-2">04</div>
                <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Hardening</h6>
                <p class="small text-muted mb-0">OWASP validation &amp; deployment.</p>
            </div>
        </div>
    </div>

    <!-- CALL TO ACTION -->
    <div class="text-center py-4">
        <h4 class="fw-bold mb-3" style="color: var(--text-heading);">Ready to build your web project?</h4>
        <div class="d-flex justify-content-center gap-3">
            <a href="services.php" class="btn btn-primary btn-lg px-4 fs-6 fw-bold rounded-3">
                <i class="fa-solid fa-list-check me-2"></i> View Our Services
            </a>
            <a href="contact.php" class="btn btn-outline-primary btn-lg px-4 fs-6 fw-bold rounded-3">
                <i class="fa-solid fa-envelope me-2"></i> Get In Touch
            </a>
        </div>
    </div>

</div>

<style>
    .card-tech {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-tech:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.1) !important;
        border-color: var(--brand-primary) !important;
    }
</style>

<?php include('footer.php'); ?>
