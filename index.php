<?php
// NexusDigital - Home Page
// Displays company overview, stats, and top 3 featured services
include_once 'db.php';

// Database se sirf TOP 3 active services fetch kar rahe hain
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusDigital - Enterprise Software & Web Solutions</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-hover: #1d4ed8;
            --dark-navy: #0b132b;
            --navy-card: #1c2541;
            --light-bg: #f8fafc;
        }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #ffffff;
            color: #1e293b;
        }
        /* NAVBAR */
        .navbar-custom {
            background-color: var(--dark-navy);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        /* HERO SECTION */
        .hero-section {
            background-color: var(--dark-navy);
            color: white;
            padding: 70px 0 60px 0;
            position: relative;
        }
        .hero-badge {
            background: rgba(37, 99, 235, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(37, 99, 235, 0.4);
            font-size: 11px;
            letter-spacing: 1.2px;
            font-weight: 600;
        }
        .capability-card {
            background: var(--navy-card);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .progress-bar-custom {
            height: 6px;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }
        /* STATS CARDS */
        .stats-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px 15px;
            text-align: center;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            transition: transform 0.2s ease;
        }
        .stats-card:hover {
            transform: translateY(-3px);
        }
        /* FEATURE BOXES */
        .feature-box {
            background: #ffffff;
            border-radius: 12px;
            padding: 28px 24px;
            height: 100%;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
        }
        .feature-box:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
            border-color: #cbd5e1;
        }
        .feature-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: #eff6ff;
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 18px;
        }
        /* SERVICE CARDS */
        .service-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            transition: all 0.25s ease;
            height: 100%;
            background: #ffffff;
        }
        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        }
        .service-card img {
            height: 190px;
            object-fit: cover;
            width: 100%;
        }
        /* PROCESS STEPS */
        .step-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--primary-blue);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            margin: 0 auto 16px auto;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        /* CTA BANNER */
        .cta-banner {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 50px 0;
            text-align: center;
        }
        /* FOOTER */
        footer {
            background: #060c1a;
            color: #94a3b8;
            padding: 60px 0 25px 0;
            font-size: 14px;
        }
        footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }
        footer a:hover {
            color: #ffffff;
        }
        footer h6 {
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 18px;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="index.php">
                <i class="fa-solid fa-cube text-primary me-2 fs-3"></i>Nexus <span class="text-primary ms-1">Digital</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3 mt-3 mt-lg-0">
                    <li class="nav-item"><a class="nav-link active fw-semibold" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="contact.php">Contact</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-light btn-sm px-3 py-2 rounded-2 fw-semibold" href="admin_login.php">
                            <i class="fa-solid fa-user-gear me-1"></i> Admin Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION (WITH SYSTEM CAPABILITIES WIDGET) -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7 text-center text-lg-start">
                    <span class="badge hero-badge rounded-pill px-3 py-2 text-uppercase mb-3">
                        <i class="fa-solid fa-shield-check me-1"></i> ISO COMPLIANT & ENTERPRISE GRADE
                    </span>
                    <h1 class="fw-bold display-6 mb-3 text-white">
                        Engineering Dynamic Web &amp; Enterprise Software
                    </h1>
                    <p class="text-white-50 leading-relaxed mb-4 fs-6 pe-lg-4">
                        We empower corporations, fintechs, and high-growth ventures with mission-critical web applications, high-concurrency MySQL database architectures, and cloud-native solutions.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 mb-4">
                        <a href="services.php" class="btn btn-primary btn-lg px-4 fs-6 fw-semibold">
                            <i class="fa-solid fa-rocket me-2"></i> Explore Our Services
                        </a>
                        <a href="contact.php" class="btn btn-outline-light btn-lg px-4 fs-6 fw-semibold">
                            <i class="fa-regular fa-calendar-check me-2"></i> Schedule Consultation
                        </a>
                    </div>
                </div>

                <!-- RIGHT HERO WIDGET: SYSTEM CAPABILITIES -->
                <div class="col-lg-5">
                    <div class="capability-card">
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom border-secondary border-opacity-25 pb-2">
                            <span class="text-primary fw-bold small text-uppercase"><i class="fa-solid fa-sliders me-2"></i>System Capabilities</span>
                            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 small">Active Nodes</span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small text-white-50 mb-1">
                                <span>High Concurrency MySQL</span>
                                <span class="text-info fw-bold">99.9%</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="bg-info h-100" style="width: 99.9%;"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between small text-white-50 mb-1">
                                <span>Security Hardening (OWASP)</span>
                                <span class="text-success fw-bold">100%</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="bg-success h-100" style="width: 100%;"></div>
                            </div>
                        </div>

                        <div class="mb-1">
                            <div class="d-flex justify-content-between small text-white-50 mb-1">
                                <span>Mobile &amp; Cross-Platform UX</span>
                                <span class="text-warning fw-bold">98%</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="bg-warning h-100" style="width: 98%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATS ROW -->
            <div class="row g-3 mt-4">
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <h3 class="fw-bold text-primary mb-0">150+</h3>
                        <span class="text-muted small fw-semibold">Enterprise Systems Delivered</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <h3 class="fw-bold text-success mb-0">99.9%</h3>
                        <span class="text-muted small fw-semibold">SLA Service Uptime</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <h3 class="fw-bold text-info mb-0">50+</h3>
                        <span class="text-muted small fw-semibold">Corporate Clients</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <h3 class="fw-bold text-warning mb-0">24/7</h3>
                        <span class="text-muted small fw-semibold">Engineering Support</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY NEXUSDIGITAL SECTION -->
    <section class="py-5 bg-light border-bottom">
        <div class="container py-3">
            <div class="text-center mb-5 max-w-700 mx-auto">
                <span class="text-primary fw-bold text-uppercase small tracking-wide">WHY NEXUSDIGITAL</span>
                <h2 class="fw-bold mt-1 text-dark">Built For Reliability, Scalability &amp; Security</h2>
                <p class="text-muted small">We combine rigorous backend engineering standards with modern digital user experiences.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <h6 class="fw-bold text-dark">High Concurrency Architecture</h6>
                        <p class="text-muted small mb-0">Engineered with clean object-oriented codebases capable of executing complex transactional workloads smoothly under peak client loads.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Normalized Database Design</h6>
                        <p class="text-muted small mb-0">Normalized relational MySQL schemas utilizing foreign key constraints, indexed tables, and data integrity enforcement for high speeds.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h6 class="fw-bold text-dark">End-to-End OWASP Security</h6>
                        <p class="text-muted small mb-0">Prepared statements, CSRF validation, password hashing, and role-based access control (RBAC) to ensure enterprise data privacy.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Omni-Channel Responsiveness</h6>
                        <p class="text-muted small mb-0">Tailored user interfaces designed specifically for mobile, tablet, and desktop viewports without functional compromise.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURED SERVICES (EXACTLY 3 CARDS WITH INQUIRE & VIEW ALL LINKS) -->
    <section class="py-5">
        <div class="container py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-2">
                <div>
                    <span class="text-primary fw-bold text-uppercase small">OUR ACTIVE PORTFOLIO</span>
                    <h2 class="fw-bold mb-0 text-dark">Featured Software Solutions</h2>
                </div>
                <div>
                    <!-- WORKING LINK TO SERVICES.PHP -->
                    <a href="services.php" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
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
                                <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($service['title']); ?>">
                                <div class="card-body d-flex flex-column p-4">
                                    <span class="badge bg-primary bg-opacity-10 text-primary w-auto align-self-start mb-2 px-2 py-1 small fw-semibold">
                                        <?php echo htmlspecialchars($catName); ?>
                                    </span>
                                    <h5 class="fw-bold text-dark"><?php echo htmlspecialchars($service['title']); ?></h5>
                                    <p class="text-muted small flex-grow-1 mb-3">
                                        <?php echo htmlspecialchars(substr($service['description'], 0, 110)) . '...'; ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 11px;">Starting at</small>
                                            <span class="fw-bold text-dark fs-6">Rs. <?php echo number_format($service['price']); ?></span>
                                        </div>
                                        <!-- WORKING INQUIRE BUTTON DIRECTING TO CONTACT.PHP -->
                                        <a href="contact.php?service_id=<?php echo $service['id']; ?>" class="btn btn-primary btn-sm px-3 fw-semibold">
                                            <i class="fa-solid fa-paper-plane me-1"></i> Inquire
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // Static Fallback Cards (Exactly 3) if Database is empty
                    ?>
                    <div class="col-md-4">
                        <div class="service-card d-flex flex-column">
                            <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80" alt="Database Architecture">
                            <div class="card-body d-flex flex-column p-4">
                                <span class="badge bg-primary bg-opacity-10 text-primary align-self-start mb-2 px-2 py-1 small fw-semibold">Database Architecture &amp; Security</span>
                                <h5 class="fw-bold text-dark">MySQL Database Optimization &amp; Security</h5>
                                <p class="text-muted small flex-grow-1 mb-3">Database normalization, indexing, query optimization, high-availability replication, and OWASP security hardening.</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 11px;">Starting at</small>
                                        <span class="fw-bold text-dark fs-6">Rs. 14,000</span>
            </div>
            <a href="services.php" class="btn btn-sm btn-primary rounded-pill px-3">Book Now</a>
        </div>
    </div>
</div>
<?php } ?> <!-- Yahan yeh closing bracket lagana zaroori tha -->

</div> <!-- Row End -->
</div> <!-- Container End -->
</section>

<!-- Footer -->
<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
