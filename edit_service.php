<?php
// NexusDigital - Enterprise Service Editor Component
session_start();
include('db.php');

// Admin Session Guard
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

$service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";
$error = "";

// Secure Query: Fetch existing service data using Prepared Statements
$stmt = $conn->prepare("SELECT * FROM services WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $service_id);
$stmt->execute();
$service_res = $stmt->get_result();

if (!$service_res || $service_res->num_rows == 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en" data-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Service Not Found - NexusDigital Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; background: #f8fafc; color: #334155; }
        </style>
    </head>
    <body class="d-flex align-items-center justify-content-center min-vh-100 p-3">
        <div class="card border-0 shadow-lg rounded-4 p-5 text-center" style="max-width: 500px; width: 100%;">
            <i class="fa-solid fa-triangle-exclamation fa-3x text-warning mb-3"></i>
            <h3 class="fw-extrabold text-dark mb-2">Service Record Not Found</h3>
            <p class="text-muted small mb-4">Aap jis service ko edit karna chahte hain woh database mein maujood nahi hai ya remove kar di gayi hai.</p>
            <a href="admin_dashboard.php" class="btn btn-primary fw-bold py-2 px-4 rounded-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Return to Admin Dashboard
            </a>
        </div>
    </body>
    </html>
    <?php
    exit();
}

$service = $service_res->fetch_assoc();

// Fetch active categories for relational dropdown
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");

// Secure Form Submission Handling
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_service'])) {
    $title = trim($_POST['title']);
    $category_id = intval($_POST['category_id']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $image_name = $service['image']; // Retain existing image by default

    // Handle Image Upload securely if new file provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            @mkdir($target_dir, 0777, true);
        }
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = array('jpg', 'jpeg', 'png', 'webp');

        if (in_array($file_ext, $allowed)) {
            $new_filename = time() . '_' . uniqid() . '.' . $file_ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $new_filename)) {
                $image_name = $new_filename;
            }
        } else {
            $error = "Invalid image format! Only JPG, JPEG, PNG, and WEBP formats are permitted.";
        }
    }

    if (empty($error)) {
        $update_stmt = $conn->prepare("UPDATE services SET title = ?, category_id = ?, price = ?, description = ?, image = ? WHERE id = ?");
        $update_stmt->bind_param("sidssi", $title, $category_id, $price, $description, $image_name, $service_id);

        if ($update_stmt->execute()) {
            $message = "Service record successfully updated!";
            // Update local state variables for accurate page re-render
            $service['title'] = $title;
            $service['category_id'] = $category_id;
            $service['price'] = $price;
            $service['description'] = $description;
            $service['image'] = $image_name;
        } else {
            $error = "Database Execution Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service #<?php echo $service_id; ?> - NexusDigital Admin</title>
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
            --navbar-bg: #0f172a;
        }

        [data-theme="dark"] {
            --body-bg: #0b0f19;
            --text-main: #94a3b8;
            --text-heading: #f8fafc;
            --card-bg: #111827;
            --card-border: #1f2937;
            --input-bg: #1f2937;
            --navbar-bg: #030712;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--body-bg);
            color: var(--text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-custom {
            background-color: var(--navbar-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .card-custom {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.03);
        }

        .form-control, .form-select {
            background-color: var(--input-bg);
            color: var(--text-heading);
            border-color: var(--card-border);
            border-radius: 12px;
            padding: 12px 16px;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--input-bg);
            color: var(--text-heading);
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        .input-group-text {
            background-color: var(--input-bg);
            border-color: var(--card-border);
            color: var(--text-main);
            border-radius: 12px 0 0 12px;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0;
        }

        .btn-brand {
            background: var(--brand-gradient);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 12px 28px;
            font-weight: 700;
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
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-extrabold d-flex align-items-center fs-5" href="admin_dashboard.php">
            <i class="fa-solid fa-shield-halved text-primary me-2 fs-4"></i>NexusDigital Admin
        </a>

        <div class="d-flex align-items-center gap-2">
            <button class="theme-toggle-btn me-2" id="themeToggleBtn" title="Toggle Theme">
                <i class="fa-solid fa-moon text-white" id="themeIcon"></i>
            </button>
            <a href="admin_dashboard.php" class="btn btn-outline-light btn-sm rounded-3 px-3 fw-semibold">
                <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </div>
</nav>

<div class="container py-5" style="max-width: 900px;">

    <!-- TOP CONTROL BAR -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="admin_dashboard.php" class="btn btn-outline-secondary btn-sm px-3 rounded-3 fw-semibold">
            <i class="fa-solid fa-chevron-left me-1"></i> Back to Services
        </a>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">
            <i class="fa-solid fa-pen-to-square me-1"></i> Editing Record #<?php echo $service_id; ?>
        </span>
    </div>

    <!-- EDIT FORM CARD -->
    <div class="card card-custom p-4 p-md-5">
        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3" style="border-color: var(--card-border) !important;">
            <div class="p-3 rounded-4 bg-primary bg-opacity-10 text-primary">
                <i class="fa-solid fa-pen-to-square fa-xl"></i>
            </div>
            <div>
                <h3 class="fw-extrabold mb-1" style="color: var(--text-heading);">Edit Service Record</h3>
                <p class="text-muted small mb-0">Update service information, pricing tiers, category tags, and preview thumbnail.</p>
            </div>
        </div>

        <!-- ALERTS -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 small mb-4 fw-semibold shadow-sm">
                <i class="fa-solid fa-circle-check me-2"></i> <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 small mb-4 fw-semibold shadow-sm">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="row g-4">
                <div class="col-md-8">
                    <label class="form-label fw-bold small" style="color: var(--text-heading);">Service Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($service['title']); ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small" style="color: var(--text-heading);">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <option value="" disabled>Select Category</option>
                        <?php if ($categories && $categories->num_rows > 0): ?>
                            <?php while ($cat = $categories->fetch_assoc()): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $service['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold small" style="color: var(--text-heading);">Package Price (PKR) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text fw-bold">Rs.</span>
                        <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($service['price']); ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold small" style="color: var(--text-heading);">Upload New Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <?php if (!empty($service['image'])): ?>
                    <div class="col-12">
                        <label class="form-label fw-bold small d-block" style="color: var(--text-heading);">Active Thumbnail Preview</label>
                        <?php 
                            $imgSrc = filter_var($service['image'], FILTER_VALIDATE_URL) ? $service['image'] : 'uploads/' . $service['image'];
                        ?>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-4 border" style="border-color: var(--card-border) !important; background: var(--input-bg);">
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="Current Service Media" class="rounded-3 shadow-sm border" style="height: 70px; width: 70px; object-fit: cover;">
                            <div>
                                <span class="fw-bold small d-block" style="color: var(--text-heading);"><?php echo htmlspecialchars(basename($service['image'])); ?></span>
                                <span class="text-muted small">Current stored thumbnail file in system.</span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-12">
                    <label class="form-label fw-bold small" style="color: var(--text-heading);">Technical Specifications &amp; Details <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                </div>

                <div class="col-12 pt-3 d-flex gap-2">
                    <button type="submit" name="update_service" class="btn btn-brand">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save &amp; Update Record
                    </button>
                    <a href="admin_dashboard.php" class="btn btn-outline-secondary rounded-3 px-4 fw-semibold d-inline-flex align-items-center">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Dark / Light Theme Sync Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const themeBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        
        const currentTheme = localStorage.getItem('nexusTheme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);
        updateIcon(currentTheme);

        if (themeBtn) {
            themeBtn.addEventListener('click', () => {
                let theme = document.documentElement.getAttribute('data-theme');
                let newTheme = theme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('nexusTheme', newTheme);
                updateIcon(newTheme);
            });
        }

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
