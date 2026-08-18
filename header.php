<?php
// Active page URL check karne ke liye logic
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusDigital - Enterprise Software & Web Engineering</title>
    
    <!-- PREVENT FLASH OF UNSTYLED THEME (INSTANT THEME LOAD) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('nexusTheme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

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
            
            --nav-bg: #f1f5f9;
            --nav-border: #cbd5e1;
            --hero-bg: linear-gradient(135deg, #f8fafc 0%, #edf2f7 50%, #e2e8f0 100%);
            --hero-title-color: #0f172a;
            --hero-text-color: #475569;
            
            --sec-light-bg: #f8fafc;
            --sec-accent-bg: #eff6ff;
            
            --body-bg: #ffffff;
            --text-main: #334155;
            --text-heading: #0f172a;
            --text-muted: #64748b;
            
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --card-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05);
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
            
            --sec-light-bg: #0f172a;
            --sec-accent-bg: #090d16;
            
            --body-bg: #090d16;
            --text-main: #e2e8f0;
            --text-heading: #f8fafc;
            --text-muted: #94a3b8;
            
            --card-bg: #111827;
            --card-border: #1f2937;
            --card-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }

        /* GLOBAL STYLES */
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--body-bg) !important;
            color: var(--text-main) !important;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        /* SUBPAGES AUTOMATIC DARK MODE ADAPTATION */
        [data-theme="dark"] h1, 
        [data-theme="dark"] h2, 
        [data-theme="dark"] h3, 
        [data-theme="dark"] h4, 
        [data-theme="dark"] h5, 
        [data-theme="dark"] h6,
        [data-theme="dark"] .text-dark {
            color: var(--text-heading) !important;
        }

        [data-theme="dark"] .card, 
        [data-theme="dark"] .feature-box, 
        [data-theme="dark"] .service-card,
        [data-theme="dark"] .bg-white,
        [data-theme="dark"] .bg-light {
            background-color: var(--card-bg) !important;
            border-color: var(--card-border) !important;
            color: var(--text-main) !important;
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #f8fafc !important;
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: #1f2937 !important;
            color: #f8fafc !important;
            border-color: var(--brand-primary) !important;
        }

        /* NAVBAR STYLES */
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

        .navbar-toggler {
            border: 1.5px solid var(--nav-border) !important;
            padding: 6px 10px;
            border-radius: 8px;
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
    </style>
</head>
<body>

    <!-- STICKY NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand fs-4 d-flex align-items-center" href="index.php">
                <i class="fa-solid fa-cube text-primary me-2 fs-3"></i>Nexus <span class="text-primary ms-1">Digital</span>
            </a>
            
            <div class="d-flex align-items-center gap-2 order-lg-3">
                <button class="theme-toggle-btn me-1" id="themeToggleBtn" title="Toggle Light/Dark Theme">
                    <i class="fa-solid fa-moon text-primary" id="themeIcon"></i>
                </button>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon">
                        <i class="fa-solid fa-bars"></i>
                    </span>
                </button>
            </div>
            
            <div class="collapse navbar-collapse order-lg-2" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-1 mt-3 mt-lg-0 me-lg-3">
                    <li class="nav-item"><a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($current_page == 'services.php') ? 'active' : ''; ?>" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="contact.php">Contact</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-primary btn-sm px-3 py-2 rounded-3 fw-bold" href="admin_login.php">
                            <i class="fa-solid fa-user-gear me-1"></i> Admin Portal
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- GLOBAL THEME TOGGLE SCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');
            
            if (!themeToggleBtn) return;

            function updateIcon(theme) {
                if (themeIcon) {
                    if (theme === 'dark') {
                        themeIcon.className = 'fa-solid fa-sun text-warning';
                    } else {
                        themeIcon.className = 'fa-solid fa-moon text-primary';
                    }
                }
            }

            // Sync icon on page load
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            updateIcon(currentTheme);

            // Toggle Click Handler
            themeToggleBtn.addEventListener('click', () => {
                let theme = document.documentElement.getAttribute('data-theme');
                let newTheme = theme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('nexusTheme', newTheme);
                updateIcon(newTheme);
            });
        });
    </script>
