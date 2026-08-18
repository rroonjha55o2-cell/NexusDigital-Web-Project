<?php
// NexusDigital - Enterprise Admin Management Portal
session_start();
include('db.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

$message = '';
$error = '';

// Handle Service Insertion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_service'])) {
    $title = trim($_POST['title']);
    $category_id = intval($_POST['category_id']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $image_name = time() . '_' . uniqid() . '.' . $ext;
            if (!is_dir('uploads')) {
                @mkdir('uploads', 0777, true);
            }
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image_name);
        } else {
            $error = 'Invalid image format. Allowed: JPG, PNG, WEBP';
        }
    }

    if (empty($error)) {
        $stmt = $conn->prepare("INSERT INTO services (category_id, title, description, price, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issds", $category_id, $title, $description, $price, $image_name);
        if ($stmt->execute()) {
            $message = "New enterprise service added successfully!";
        } else {
            $error = "Error adding service: " . $conn->error;
        }
    }
}

// Fetch Quick Statistics Data
$stat_services_res = $conn->query("SELECT COUNT(*) as total FROM services");
$total_services = ($stat_services_res) ? $stat_services_res->fetch_assoc()['total'] : 0;

$stat_cats_res = $conn->query("SELECT COUNT(*) as total FROM categories");
$total_cats = ($stat_cats_res) ? $stat_cats_res->fetch_assoc()['total'] : 0;

$stat_contacts_res = $conn->query("SELECT COUNT(*) as total FROM contacts");
$total_contacts = ($stat_contacts_res) ? $stat_contacts_res->fetch_assoc()['total'] : 0;

// Fetch Categories & Main Datasets
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
$services = $conn->query("SELECT s.*, c.name as category_name FROM services s LEFT JOIN categories c ON s.category_id = c.id ORDER BY s.id DESC");
$contacts = $conn->query("SELECT * FROM contacts ORDER BY id DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NexusDigital Systems</title>
    
    <!-- PREVENT FLASH OF UNSTYLED THEME -->
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
        :root {
            --brand-primary: #2563eb;
            --brand-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --body-bg: #f8fafc;
            --text-main: #334155;
            --text-heading: #0f172a;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --input-bg: #f8fafc;
            --table-hover: #f1f5f9;
            --navbar-bg: #0f172a;
            --stat-card-bg: #ffffff;
            --stat-label: #64748b;
        }

        [data-theme="dark"] {
            --body-bg: #0b0f19;
            --text-main: #94a3b8;
            --text-heading: #f8fafc;
            --card-bg: #111827;
            --card-border: #1f2937;
            --input-bg: #1f2937;
            --table-hover: #1e293b;
            --navbar-bg: #030712;
            --stat-card-bg: #111827;
            --stat-label: #cbd5e1;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--body-bg) !important;
            color: var(--text-main) !important;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-custom {
            background-color: var(--navbar-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .card-custom {
            background-color: var(--card-bg) !important;
            border: 1px solid var(--card-border) !important;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .card-custom .card-header {
            background: transparent;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-heading);
        }

        .stat-card {
            background-color: var(--stat-card-bg) !important;
            border: 1px solid var(--card-border) !important;
            border-radius: 16px;
            padding: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.05);
        }

        .stat-label-text {
            color: var(--stat-label) !important;
            letter-spacing: 0.5px;
        }

        .form-control, .form-select {
            background-color: var(--input-bg) !important;
            color: var(--text-heading) !important;
            border-color: var(--card-border) !important;
            border-radius: 10px;
            padding: 11px 14px;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--input-bg) !important;
            color: var(--text-heading) !important;
            border-color: var(--brand-primary) !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        /* DARK MODE FILE INPUT BUTTON FIX */
        [data-theme="dark"] .form-control::file-selector-button {
            background-color: #374151;
            color: #f8fafc;
            border-color: #4b5563;
        }

        /* GENERAL DARK MODE TEXT-MUTED FIX */
        [data-theme="dark"] .text-muted {
            color: #cbd5e1 !important;
        }

        .btn-brand {
            background: var(--brand-gradient);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
            transition: all 0.3s ease;
        }

        .btn-brand:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
            color: #ffffff;
        }

        .theme-toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* TABLE OVERRIDES FOR DARK MODE READABILITY */
        .table-custom {
            color: var(--text-main) !important;
            --bs-table-bg: transparent !important;
            --bs-table-color: var(--text-main) !important;
        }

        .table-custom th {
            color: var(--text-heading) !important;
            border-bottom: 2px solid var(--card-border) !important;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            background-color: transparent !important;
        }

        .table-custom td {
            border-bottom: 1px solid var(--card-border) !important;
            vertical-align: middle;
            color: var(--text-main) !important;
            background-color: transparent !important;
        }

        .table-custom tr {
            background-color: transparent !important;
        }

        .table-custom tr:hover td {
            background-color: var(--table-hover) !important;
        }

        [data-theme="dark"] .table-custom {
            --bs-table-bg: transparent !important;
            --bs-table-hover-bg: var(--table-hover) !important;
        }
    </style>
</head>
<body>

<!-- NAVBAR WITH MOBILE TOGGLE -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-extrabold d-flex align-items-center fs-5" href="dashboard.php">
            <i class="fa-solid fa-shield-halved text-primary me-2 fs-4"></i>NexusDigital Admin
        </a>

        <div class="d-flex align-items-center gap-2 d-lg-none">
            <button class="theme-toggle-btn" id="themeToggleBtnMobile" title="Toggle Theme">
                <i class="fa-solid fa-moon text-white"></i>
            </button>
            <button class="navbar-toggler border-0 p-2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars fs-4"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse mt-3 mt-lg-0" id="adminNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active fw-bold text-white" href="dashboard.php"><i class="fa-solid fa-chart-line me-1 text-primary"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white-50" href="#servicesSection"><i class="fa-solid fa-cubes me-1"></i> Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white-50" href="#inquiriesSection"><i class="fa-solid fa-inbox me-1"></i> Inquiries</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2 pt-2 pt-lg-0 border-top border-lg-0 border-secondary">
                <button class="theme-toggle-btn d-none d-lg-flex me-2" id="themeToggleBtn" title="Toggle Light/Dark Theme">
                    <i class="fa-solid fa-moon text-white" id="themeIcon"></i>
                </button>
                <a href="../index.php" target="_blank" class="btn btn-outline-light btn-sm rounded-3 px-3 fw-semibold">
                    <i class="fa-solid fa-globe me-1 text-info"></i> View Live Site
                </a>
                <a href="logout.php" class="btn btn-danger btn-sm rounded-3 px-3 fw-semibold">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="container my-5">

    <!-- OVERVIEW STATS CARDS -->
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <span class="stat-label-text small fw-bold text-uppercase d-block mb-1">Total Services</span>
                    <h3 class="fw-extrabold mb-0" style="color: var(--text-heading);"><?php echo number_format($total_services); ?></h3>
                </div>
                <div class="p-3 rounded-4 bg-primary bg-opacity-10 text-primary">
                    <i class="fa-solid fa-cubes fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <span class="stat-label-text small fw-bold text-uppercase d-block mb-1">Service Categories</span>
                    <h3 class="fw-extrabold mb-0" style="color: var(--text-heading);"><?php echo number_format($total_cats); ?></h3>
                </div>
                <div class="p-3 rounded-4 bg-info bg-opacity-10 text-info">
                    <i class="fa-solid fa-tags fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <span class="stat-label-text small fw-bold text-uppercase d-block mb-1">Customer Inquiries</span>
                    <h3 class="fw-extrabold mb-0" style="color: var(--text-heading);"><?php echo number_format($total_contacts); ?></h3>
                </div>
                <div class="p-3 rounded-4 bg-warning bg-opacity-10 text-warning">
                    <i class="fa-solid fa-envelope-open-text fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ALERTS -->
    <?php if($message): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4 fw-semibold">
            <i class="fa-solid fa-circle-check me-2"></i><?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4 fw-semibold">
            <i class="fa-solid fa-triangle-exclamation me-2"></i><?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- ADD SERVICE CARD -->
    <div class="card card-custom mb-5">
        <div class="card-header py-3 fw-bold fs-6 d-flex align-items-center justify-content-between">
            <span><i class="fa-solid fa-plus-circle text-primary me-2"></i>Add New Service Package</span>
            <span class="badge bg-primary bg-opacity-10 text-primary small">Upload Supported</span>
        </div>
        <div class="card-body p-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small" style="color: var(--text-heading);">Service Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Enterprise Cloud Deployment" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small" style="color: var(--text-heading);">Category (Foreign Key Mapping) <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="" disabled selected>Select Service Category</option>
                            <?php if ($categories && $categories->num_rows > 0): ?>
                                <?php while($cat = $categories->fetch_assoc()): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small" style="color: var(--text-heading);">Technical Description &amp; Scope <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Write enterprise solution specifications..." required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small" style="color: var(--text-heading);">Starting Package Price (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="25000" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small" style="color: var(--text-heading);">Service Banner Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12 pt-2">
                        <button type="submit" name="add_service" class="btn btn-brand fw-bold shadow-sm">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i> Save &amp; Publish Service
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ACTIVE SERVICES TABLE CARD -->
    <div class="card card-custom mb-5" id="servicesSection">
        <div class="card-header py-3 fw-bold fs-6 d-flex align-items-center justify-content-between">
            <span><i class="fa-solid fa-list-check text-info me-2"></i>Active Services Inventory</span>
            <span class="badge bg-secondary bg-opacity-10 text-secondary small">Real-time MySQL Data</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">Thumbnail</th>
                            <th class="py-3">Title</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Price</th>
                            <th class="py-3 text-center pe-4">CRUD Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($services && $services->num_rows > 0): ?>
                            <?php while ($row = $services->fetch_assoc()): ?>
                                <?php 
                                    $imgSrc = !empty($row['image']) 
                                        ? (filter_var($row['image'], FILTER_VALIDATE_URL) ? $row['image'] : 'uploads/' . $row['image'])
                                        : 'https://via.placeholder.com/60x60?text=No+Img';
                                ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="service" style="width: 52px; height: 52px; object-fit: cover;" class="rounded-3 shadow-sm border border-secondary border-opacity-25">
                                    </td>
                                    <td class="py-3 fw-bold" style="color: var(--text-heading);"><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td class="py-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold small">
                                            <?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 fw-extrabold text-success fs-6">Rs. <?php echo number_format($row['price']); ?></td>
                                    <td class="py-3 text-center pe-4 text-nowrap">
                                        <a href="edit_service.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm px-3 rounded-3 fw-bold me-1">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                        </a>
                                        <a href="delete_service.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this service record?');" class="btn btn-outline-danger btn-sm px-3 rounded-3 fw-bold">
                                            <i class="fa-solid fa-trash me-1"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted fw-semibold">No services found in database. Add one above!</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- RECENT CUSTOMER INQUIRIES CARD -->
    <div class="card card-custom" id="inquiriesSection">
        <div class="card-header py-3 fw-bold fs-6 d-flex align-items-center justify-content-between">
            <span><i class="fa-solid fa-envelope-open-text text-warning me-2"></i>Recent Customer Inquiries</span>
            <span class="badge bg-warning bg-opacity-10 text-warning small">Latest 10 Leads</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">Client Name</th>
                            <th class="py-3">Contact Email</th>
                            <th class="py-3">Subject</th>
                            <th class="py-3">Requirement Details</th>
                            <th class="py-3 pe-4">Logged Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($contacts && $contacts->num_rows > 0): ?>
                            <?php while($c = $contacts->fetch_assoc()): ?>
                                <tr>
                                    <td class="ps-4 py-3 fw-bold" style="color: var(--text-heading);"><?php echo htmlspecialchars($c['name']); ?></td>
                                    <td class="py-3 text-primary fw-semibold"><?php echo htmlspecialchars($c['email']); ?></td>
                                    <td class="py-3"><span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1"><?php echo htmlspecialchars($c['subject']); ?></span></td>
                                    <td class="py-3 small text-muted"><?php echo htmlspecialchars($c['message']); ?></td>
                                    <td class="py-3 pe-4 small text-muted"><?php echo !empty($c['created_at']) ? date('M d, Y', strtotime($c['created_at'])) : 'Recent'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted fw-semibold">No customer inquiries recorded yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Dark / Light Theme Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const themeBtnDesktop = document.getElementById('themeToggleBtn');
        const themeBtnMobile = document.getElementById('themeToggleBtnMobile');
        const themeIcon = document.getElementById('themeIcon');
        
        const currentTheme = localStorage.getItem('nexusTheme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);
        updateIcon(currentTheme);

        function toggleTheme() {
            let theme = document.documentElement.getAttribute('data-theme');
            let newTheme = theme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('nexusTheme', newTheme);
            updateIcon(newTheme);
        }

        if (themeBtnDesktop) themeBtnDesktop.addEventListener('click', toggleTheme);
        if (themeBtnMobile) themeBtnMobile.addEventListener('click', toggleTheme);

        function updateIcon(theme) {
            if (themeIcon) {
                if (theme === 'dark') {
                    themeIcon.className = 'fa-solid fa-sun text-warning';
                } else {
                    themeIcon.className = 'fa-solid fa-moon text-white';
                }
            }
        }
    });
</script>
</body>
</html>
