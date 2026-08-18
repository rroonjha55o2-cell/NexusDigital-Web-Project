<?php
// NexusDigital - Enterprise Home Page (With Light/Dark Dynamic Theme)
include_once 'db.php';

// Database se TOP 3 active services fetch kar rahe hain
$services_query = "SELECT s.*, c.name as category_name 
                  FROM services s 
                  LEFT JOIN categories c ON s.category_id = c.id 
                  ORDER BY s.id DESC LIMIT 3";
$services_result = false;
if (isset($conn) && $conn) {
    $services_result = @mysqli_query($conn, $services_query);
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusDigital - High Performance Enterprise Web Systems</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* LIGHT THEME VARIABLES (DEFAULT) */
        :root {
            --brand-primary: #2563eb;
            --brand-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --brand-accent: #0284c7;
            
            /* Distinct Light Colors per Section */
            --nav-bg: #f1f5f9;
            --nav-border: #cbd5e1;
            --hero-bg: linear-gradient(135deg, #f8fafc 0%, #edf2f7 50%, #e2e8f0 100%);
            --hero-title-color: #0f172a;
            --hero-text-color: #475569;
            
            --sec-why-bg: #eff6ff;
            --sec-services-bg: #f8fafc;
            
            --body-bg: #ffffff;
            --text-main: #334155;
            --text-heading: #0f172a;
            --text-muted: #64748b;
            
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --card-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05);
            
            /* Live Terminal/Monitor Card Styles in Light Mode */
            --term-bg: #ffffff;
            --term-border: #cbd5e1;
            --term-text: #0f172a;
            --term-subtext: #64748b;
        }

        /* DARK THEME OVERRIDES */
        [data-theme="dark"] {
            --brand-primary: #38bdf8;
            --brand-gradient: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            --brand-accent: #38bdf8;
            
            --nav-bg: #0b0f19;
            --nav-border: rgba(255, 255, 255, 0.1);
            --hero-bg: radial-gradient(circle at 80% 20%, #1e1b4b 0%, #090d16 80%);
            --hero-title-color: #f8fafc;
            --hero-text-color: #cbd5e1;
            
            --sec-why-bg: #0f172a;
            --sec-services-bg: #090d16;
            
            --body-bg: #090d16;
            --text-main: #e2e8f0;
            --text-heading: #f8fafc;
            --text-muted: #94a3b8;
            
            --card-bg: #111827;
            --card-border: #1f2937;
            --card-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
            
            --term-bg: rgba(15, 23, 42, 0.85);
            --term-border: rgba(255, 255, 255, 0.12);
            --term-text: #f8fafc;
            --term-subtext: #94a3b8;
        }

        /* OVERRIDE BOOTSTRAP MUTED TEXT FOR DARK MODE READABILITY */
        .text-muted {
            color: var(--text-muted) !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--body-bg);
            color: var(--text-main);
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* NAVBAR STYLING */
        .navbar-custom {
            background-color: var(--nav-bg);
            border-bottom: 1.5px solid var(--nav-border);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-heading) !important;
        }

        .nav-link {
            color: var(--text-main) !important;
            font-weight: 600;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--brand-primary) !important;
            background-color: rgba(37, 99, 235, 0.08);
        }

        /* Hamburger Menu Icon Fix */
        .navbar-toggler {
            border: 1.5px solid var(--nav-border) !important;
            padding: 6px 10px;
            border-radius: 8px;
        }
        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25);
        }
        .navbar-toggler-icon {
            background-image: none !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--text-heading);
        }

        /* THEME TOGGLE BUTTON */
        .theme-toggle-btn {
            background: var(--card-bg);
            border: 1.5px solid var(--card-border);
            color: var(--text-heading);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .theme-toggle-btn:hover {
            transform: scale(1.08);
            border-color: var(--brand-primary);
        }

        /* HERO SECTION */
        .hero-section {
            background: var(--hero-bg);
            padding: 80px 0 70px 0;
            border-bottom: 1px solid var(--card-border);
            transition: all 0.3s ease;
        }
        .hero-badge {
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            border: 1px solid rgba(37, 99, 235, 0.25);
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 700;
        }
        [data-theme="dark"] .hero-badge {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
            border-color: rgba(56, 189, 248, 0.3);
        }

        /* HIGH-LEVEL LIVE SYSTEM MONITOR CARD */
        .terminal-card {
            background: var(--term-bg);
            border: 1px solid var(--term-border);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(12px);
        }

        .pulse-indicator {
            width: 10px;
            height: 10px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .tech-pill {
            background: rgba(37, 99, 235, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.18);
            color: var(--brand-primary);
            font-size: 12px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* STATS CARDS */
        .stats-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 22px 16px;
            text-align: center;
            border: 1px solid var(--card-border);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            border-color: var(--brand-primary);
        }

        /* WHY NEXUSDIGITAL SECTION */
        .sec-why {
            background-color: var(--sec-why-bg);
            border-bottom: 1px solid var(--card-border);
            transition: background-color 0.3s ease;
        }

        .feature-box {
            background: var(--card-bg);
            border-radius: 18px;
            padding: 30px 24px;
            height: 100%;
            border: 1px solid var(--card-border);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }
        .feature-box:hover {
            transform: translateY(-6px);
            border-color: var(--brand-primary);
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.12);
        }
        .feature-icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 20px;
        }
        [data-theme="dark"] .feature-icon-wrapper {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
        }

        /* FEATURED SERVICES SECTION */
        .sec-services {
            background-color: var(--sec-services-bg);
            transition: background-color 0.3s ease;
        }

        .service-card {
            border: 1px solid var(--card-border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            height: 100%;
            background: var(--card-bg);
        }
        .service-card:hover {
            transform: translateY(-8px);
            border-color: var(--brand-primary);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.15);
        }
        .service-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 190px;
        }
        .service-card img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .service-card:hover img {
            transform: scale(1.08);
        }

        /* BUTTONS */
        .btn-brand {
            background: var(--brand-gradient);
            color: #ffffff !important;
            border: none;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
            transition: all 0.3s ease;
        }
        .btn-brand:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(37, 99, 235, 0.35);
        }
        .btn-outline-custom {
            border: 1.5px solid var(--card-border);
            color: var(--text-heading);
            background: var(--card-bg);
            transition: all 0.3s ease;
        }
        .btn-outline-custom:hover {
            border-color: var(--brand-primary);
            color: var(--brand-primary);
        }
    </style>
</head>
<body>

    <!-- NAVBAR WITH SEPARATE LIGHT SLATE HEADER & WORKING HAMBURGER -->
    <nav class="navbar navbar-expand-lg sticky-top navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand fs-4 d-flex align-items-center" href="index.php">
                <i class="fa-solid fa-cube text-primary me-2 fs-3"></i>Nexus <span class="text-primary ms-1">Digital</span>
            </a>
            
            <div class="d-flex align-items-center gap-2 order-lg-3">
                <!-- THEME TOGGLE BUTTON -->
                <button class="theme-toggle-btn me-1" id="themeToggleBtn" title="Toggle Light/Dark Theme">
                    <i class="fa-solid fa-moon" id="themeIcon"></i>
                </button>
                
                <!-- RESPONSIVE HAMBURGER TOGGLER WITH 3 LINES ICON -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fa-solid fa-bars"></i>
                    </span>
                </button>
            </div>
            
            <div class="collapse navbar-collapse order-lg-2" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-1 mt-3 mt-lg-0 me-lg-3">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-primary btn-sm px-3 py-2 rounded-3 fw-bold" href="admin_login.php">
                            <i class="fa-solid fa-user-gear me-1"></i> Admin Portal
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <span class="badge hero-badge rounded-pill px-3 py-2 text-uppercase mb-3 d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-shield-halved"></i> ENTERPRISE SOFTWARE ARCHITECTURE
                    </span>
                    <h1 class="fw-extrabold display-5 mb-3 leading-tight" style="color: var(--hero-title-color);">
                        Engineering Dynamic Web &amp; Enterprise Systems
                    </h1>
                    <p class="leading-relaxed mb-4 fs-6 pe-lg-4" style="color: var(--hero-text-color);">
                        We empower corporations, fintechs, and high-growth ventures with mission-critical web applications, high-concurrency MySQL database architectures, and OWASP-secured cloud solutions.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 mb-2">
                        <a href="services.php" class="btn btn-brand btn-lg px-4 fs-6 fw-bold rounded-3">
                            <i class="fa-solid fa-rocket me-2"></i> Explore Services
                        </a>
                        <a href="contact.php" class="btn btn-outline-custom btn-lg px-4 fs-6 fw-bold rounded-3">
                            <i class="fa-regular fa-calendar-check me-2"></i> Schedule Consultation
                        </a>
                    </div>
                </div>

                <!-- RIGHT HERO WIDGET: LIVE ENTERPRISE TECH MONITOR CARD -->
                <div class="col-lg-5">
                    <div class="terminal-card">
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                            <div class="d-flex align-items-center gap-2">
                                <span class="pulse-indicator"></span>
                                <span class="fw-bold text-uppercase small tracking-wider" style="color: var(--term-text);">Live System Core</span>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 small fw-bold">
                                99.99% Uptime
                            </span>
                        </div>
                        
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2 fs-6" style="color: var(--term-text);">Core Technology Capabilities</h6>
                            <p class="small mb-3" style="color: var(--term-subtext);">High-performance production stack configured for high concurrency and operational scalability.</p>
                            
                            <div class="d-flex flex-wrap gap-2">
                                <span class="tech-pill"><i class="fa-solid fa-database"></i> MySQL 8.0 Normalized</span>
                                <span class="tech-pill"><i class="fa-solid fa-code"></i> PHP 8.2 Object-Oriented</span>
                                <span class="tech-pill"><i class="fa-solid fa-lock"></i> OWASP Top-10 Hardened</span>
                                <span class="tech-pill"><i class="fa-solid fa-bolt"></i> High-Speed Caching</span>
                                <span class="tech-pill"><i class="fa-solid fa-mobile-screen"></i> 100% Mobile Responsive</span>
                            </div>
                        </div>

                        <div class="pt-3 border-top border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                            <span class="small" style="color: var(--term-subtext);"><i class="fa-solid fa-server me-1"></i> Status: Operational</span>
                            <a href="about.php" class="small text-decoration-none fw-bold" style="color: var(--brand-primary);">System Specs &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATS ROW WITH FLOATING CARDS -->
            <div class="row g-3 mt-4">
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <h3 class="fw-extrabold text-primary mb-1">150+</h3>
                        <span class="small fw-semibold text-muted">Deployed Systems</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <h3 class="fw-extrabold text-success mb-1">99.9%</h3>
                        <span class="small fw-semibold text-muted">SLA Guarantee</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <h3 class="fw-extrabold text-info mb-1">50+</h3>
                        <span class="small fw-semibold text-muted">Corporate Clients</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <h3 class="fw-extrabold text-warning mb-1">24/7</h3>
                        <span class="small fw-semibold text-muted">Engineering Support</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY NEXUSDIGITAL SECTION -->
    <section class="py-5 sec-why">
        <div class="container py-4">
            <div class="text-center mb-5 max-w-700 mx-auto">
                <span class="text-primary fw-bold text-uppercase small tracking-wide">WHY NEXUSDIGITAL</span>
                <h2 class="fw-extrabold mt-1" style="color: var(--text-heading);">Built For Reliability, Scalability &amp; Security</h2>
                <p class="small text-muted">We combine rigorous backend engineering standards with modern digital user experiences.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: var(--text-heading);">High Concurrency</h6>
                        <p class="small text-muted mb-0">Engineered with clean object-oriented codebases capable of executing complex workloads smoothly.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: var(--text-heading);">Normalized Database</h6>
                        <p class="small text-muted mb-0">Normalized relational MySQL schemas utilizing foreign key constraints, indexed tables, and integrity.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: var(--text-heading);">OWASP Security</h6>
                        <p class="small text-muted mb-0">Prepared statements, CSRF validation, password hashing, and role-based access control privacy.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: var(--text-heading);">Omni Responsiveness</h6>
                        <p class="small text-muted mb-0">Tailored user interfaces designed specifically for mobile, tablet, and desktop viewports seamlessly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURED SERVICES SECTION -->
    <section class="py-5 sec-services border-bottom">
        <div class="container py-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-2">
                <div>
                    <span class="text-primary fw-bold text-uppercase small">OUR ACTIVE PORTFOLIO</span>
                    <h2 class="fw-extrabold mb-0" style="color: var(--text-heading);">Featured Software Solutions</h2>
                </div>
                <div>
                    <a href="services.php" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                        View All Services &rarr;
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <?php
                if ($services_result && mysqli_num_rows($services_result) > 0) {
                    while ($service = mysqli_fetch_assoc($services_result)) {
                        $imgSrc = !empty($service['image']) 
                            ? (filter_var($service['image'], FILTER_VALIDATE_URL) ? $service['image'] : 'uploads/' . $service['image'])
                            : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80';
                        $catName = !empty($service['category_name']) ? $service['category_name'] : 'Software Engineering';
                        ?>
                        <div class="col-md-4">
                            <div class="service-card d-flex flex-column">
                                <div class="service-img-wrapper">
                                    <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($service['title']); ?>">
                                </div>
                                <div class="card-body d-flex flex-column p-4">
                                    <span class="badge bg-primary bg-opacity-10 text-primary align-self-start mb-2 px-3 py-1 small fw-bold rounded-pill">
                                        <?php echo htmlspecialchars($catName); ?>
                                    </span>
                                    <h5 class="fw-bold mb-2" style="color: var(--text-heading);"><?php echo htmlspecialchars($service['title']); ?></h5>
                                    <p class="small text-muted flex-grow-1 mb-3">
                                        <?php echo htmlspecialchars(substr($service['description'], 0, 110)) . '...'; ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-secondary border-opacity-25">
                                        <div>
                                            <small class="d-block text-muted" style="font-size: 11px;">Starting at</small>
                                            <span class="fw-extrabold text-primary fs-6">Rs. <?php echo number_format($service['price']); ?></span>
                                        </div>
                                        <a href="contact.php?service_id=<?php echo $service['id']; ?>" class="btn btn-brand btn-sm px-3 fw-bold rounded-3">
                                            <i class="fa-solid fa-paper-plane me-1"></i> Inquire
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // Static Fallbacks
                    ?>
                    <div class="col-md-4">
                        <div class="service-card d-flex flex-column">
                            <div class="service-img-wrapper">
                                <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80" alt="Database Optimization">
                            </div>
                            <div class="card-body d-flex flex-column p-4">
                                <span class="badge bg-primary bg-opacity-10 text-primary align-self-start mb-2 px-3 py-1 small fw-bold rounded-pill">Database &amp; Security</span>
                                <h5 class="fw-bold mb-2" style="color: var(--text-heading);">MySQL Optimization &amp; Security</h5>
                                <p class="small text-muted flex-grow-1 mb-3">Database normalization, indexing, query optimization, high-availability replication, and OWASP security hardening.</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-secondary border-opacity-25">
                                    <div>
                                        <small class="d-block text-muted" style="font-size: 11px;">Starting at</small>
                                        <span class="fw-extrabold text-primary fs-6">Rs. 14,000</span>
                                    </div>
                                    <a href="contact.php" class="btn btn-brand btn-sm px-3 fw-bold rounded-3">
                                        <i class="fa-solid fa-paper-plane me-1"></i> Inquire
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="service-card d-flex flex-column">
                            <div class="service-img-wrapper">
                                <img src="https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=600&q=80" alt="UI UX Design">
                            </div>
                            <div class="card-body d-flex flex-column p-4">
                                <span class="badge bg-primary bg-opacity-10 text-primary align-self-start mb-2 px-3 py-1 small fw-bold rounded-pill">Product Design</span>
                                <h5 class="fw-bold mb-2" style="color: var(--text-heading);">Corporate UI/UX Design System</h5>
                                <p class="small text-muted flex-grow-1 mb-3">End-to-end product design, wireframing, high-fidelity UI prototypes, and accessible component libraries.</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-secondary border-opacity-25">
                                    <div>
                                        <small class="d-block text-muted" style="font-size: 11px;">Starting at</small>
                                        <span class="fw-extrabold text-primary fs-6">Rs. 12,000</span>
                                    </div>
                                    <a href="contact.php" class="btn btn-brand btn-sm px-3 fw-bold rounded-3">
                                        <i class="fa-solid fa-paper-plane me-1"></i> Inquire
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="service-card d-flex flex-column">
                            <div class="service-img-wrapper">
                                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=600&q=80" alt="Cloud Infrastructure">
                            </div>
                            <div class="card-body d-flex flex-column p-4">
                                <span class="badge bg-primary bg-opacity-10 text-primary align-self-start mb-2 px-3 py-1 small fw-bold rounded-pill">Cloud &amp; DevOps</span>
                                <h5 class="fw-bold mb-2" style="color: var(--text-heading);">Cloud DevOps &amp; Infrastructure</h5>
                                <p class="small text-muted flex-grow-1 mb-3">Automated CI/CD pipelines, containerized deployments, server load balancing, and 99.9% uptime architecture.</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-secondary border-opacity-25">
                                    <div>
                                        <small class="d-block text-muted" style="font-size: 11px;">Starting at</small>
                                        <span class="fw-extrabold text-primary fs-6">Rs. 18,000</span>
                                    </div>
                                    <a href="contact.php" class="btn btn-brand btn-sm px-3 fw-bold rounded-3">
                                        <i class="fa-solid fa-paper-plane me-1"></i> Inquire
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- FOOTER INCLUSION -->
    <?php include_once 'footer.php'; ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- THEME TOGGLE SCRIPT -->
    <script>
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        
        // LocalStorage se saved theme restore karna
        const currentTheme = localStorage.getItem('nexusTheme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);
        updateIcon(currentTheme);

        themeToggleBtn.addEventListener('click', () => {
            let theme = document.documentElement.getAttribute('data-theme');
            let newTheme = theme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('nexusTheme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'fa-solid fa-sun text-warning';
            } else {
                themeIcon.className = 'fa-solid fa-moon text-primary';
            }
        }
    </script>
</body>
</html>
