<?php
// NexusDigital - Detailed Service View (Dynamic Specs & Clean UI)
include 'db.php';
include 'header.php';

$service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch service details
$query = "SELECT services.*, categories.name AS category_name 
          FROM services 
          LEFT JOIN categories ON services.category_id = categories.id 
          WHERE services.id = $service_id";
$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    echo "<div class='container my-5 py-5 text-center'>
            <div class='card p-5 border rounded-4 max-w-lg mx-auto shadow-sm' style='background: var(--card-bg); border-color: var(--card-border) !important;'>
                <i class='fa-solid fa-circle-exclamation fa-3x text-warning mb-3'></i>
                <h2 class='fw-bold mb-2' style='color: var(--text-heading);'>Service Not Found</h2>
                <a href='services.php' class='btn btn-primary mx-auto px-4 fw-bold mt-3'>
                    <i class='fa-solid fa-arrow-left me-2'></i> Back To All Services
                </a>
            </div>
          </div>";
    include 'footer.php';
    exit();
}

$service = $result->fetch_assoc();

// Image Src Handling
$imgSrc = '';
if (!empty($service['image'])) {
    $imgSrc = filter_var($service['image'], FILTER_VALIDATE_URL) ? $service['image'] : 'uploads/' . $service['image'];
}

// Function to generate dynamic features based on Service Name & Category
function getServiceFeatures($title, $category) {
    $text = strtolower($title . ' ' . $category);
    
    if (strpos($text, 'ui') !== false || strpos($text, 'ux') !== false || strpos($text, 'design') !== false) {
        return [
            ['icon' => 'fa-pen-ruler', 'color' => 'text-primary', 'title' => 'Figma Wireframing', 'desc' => 'High-fidelity UI prototypes'],
            ['icon' => 'fa-mobile-screen', 'color' => 'text-info', 'title' => 'Responsive Layout', 'desc' => 'Mobile-first design system'],
            ['icon' => 'fa-palette', 'color' => 'text-warning', 'title' => 'Design Tokens', 'desc' => 'Consistent typography & colors'],
            ['icon' => 'fa-universal-access', 'color' => 'text-success', 'title' => 'UX Accessibility', 'desc' => 'WCAG standards compliant']
        ];
    } elseif (strpos($text, 'database') !== false || strpos($text, 'mysql') !== false || strpos($text, 'sql') !== false) {
        return [
            ['icon' => 'fa-database', 'color' => 'text-primary', 'title' => '3NF Normalization', 'desc' => 'Optimized table structures'],
            ['icon' => 'fa-bolt', 'color' => 'text-info', 'title' => 'Query Optimization', 'desc' => 'Indexed foreign key schema'],
            ['icon' => 'fa-shield-halved', 'color' => 'text-warning', 'title' => 'ACID Compliance', 'desc' => 'Secure transaction processing'],
            ['icon' => 'fa-hard-drive', 'color' => 'text-success', 'title' => 'Data Integrity', 'desc' => 'Foreign key relational rules']
        ];
    } elseif (strpos($text, 'cloud') !== false || strpos($text, 'devops') !== false) {
        return [
            ['icon' => 'fa-server', 'color' => 'text-primary', 'title' => 'Server Architecture', 'desc' => 'Apache & Nginx environment config'],
            ['icon' => 'fa-arrows-rotate', 'color' => 'text-info', 'title' => 'Deployment Workflow', 'desc' => 'Automated server routines'],
            ['icon' => 'fa-gauge-high', 'color' => 'text-warning', 'title' => 'Performance Tuning', 'desc' => 'Cache layer & load balancing'],
            ['icon' => 'fa-lock', 'color' => 'text-success', 'title' => 'SSL Hardening', 'desc' => 'HTTPS & firewall integration']
        ];
    } else {
        return [
            ['icon' => 'fa-code', 'color' => 'text-primary', 'title' => 'Clean PHP Architecture', 'desc' => 'Modular codebase structure'],
            ['icon' => 'fa-table', 'color' => 'text-info', 'title' => 'MySQL Database CRUD', 'desc' => 'Relational data management'],
            ['icon' => 'fa-shield-cat', 'color' => 'text-warning', 'title' => 'OWASP Security', 'desc' => 'SQLi & XSS protection'],
            ['icon' => 'fa-layer-group', 'color' => 'text-success', 'title' => 'Admin Panel Integration', 'desc' => 'Custom management controls']
        ];
    }
}

$dynamic_features = getServiceFeatures($service['title'], $service['category_name'] ?? '');

// Form Handling
$success_msg = "";
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_inquiry'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string("Inquiry for: " . $service['title']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contacts (service_id, name, email, subject, message) VALUES ($service_id, '$name', '$email', '$subject', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        $success_msg = "Thank you! Your inquiry has been submitted successfully.";
    } else {
        $error_msg = "Database Error: " . $conn->error;
    }
}
?>

<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom" style="border-color: var(--card-border) !important;">
        <a href="services.php" class="btn btn-outline-secondary btn-sm px-3 rounded-3 fw-bold">
            <i class="fa-solid fa-arrow-left me-1"></i> Back To Capabilities
        </a>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">
            <i class="fa-solid fa-tag me-1"></i> <?php echo htmlspecialchars($service['category_name'] ?? 'Software Solution'); ?>
        </span>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border rounded-4 overflow-hidden shadow-sm mb-4" style="background: var(--card-bg); border-color: var(--card-border) !important;">
                <?php if (!empty($imgSrc)): ?>
                    <img src="<?php echo htmlspecialchars($imgSrc); ?>" class="img-fluid w-100" style="max-height: 380px; object-fit: cover;" alt="<?php echo htmlspecialchars($service['title']); ?>">
                <?php else: ?>
                    <div class="bg-secondary bg-opacity-10 text-muted d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="fa-solid fa-laptop-code fa-4x opacity-50"></i>
                    </div>
                <?php endif; ?>

                <div class="card-body p-4 p-md-5">
                    <h1 class="fw-extrabold display-6 mb-3" style="color: var(--text-heading);"><?php echo htmlspecialchars($service['title']); ?></h1>
                    
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--card-border) !important;">
                        <div>
                            <span class="text-muted small text-uppercase fw-bold d-block">Starting Package Price</span>
                            <span class="fs-2 fw-extrabold text-success">Rs. <?php echo number_format($service['price']); ?></span>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3" style="color: var(--text-heading);"><i class="fa-solid fa-circle-info text-primary me-2"></i>Overview & System Scope</h5>
                    <p class="text-muted mb-4" style="line-height: 1.8; font-size: 16px;">
                        <?php echo nl2br(htmlspecialchars($service['description'])); ?>
                    </p>

                    <!-- DYNAMIC SPECIFICATIONS GRID -->
                    <h5 class="fw-bold mb-3 pt-3 border-top" style="color: var(--text-heading); border-color: var(--card-border) !important;">
                        <i class="fa-solid fa-list-check text-primary me-2"></i> Technical Specifications
                    </h5>
                    
                    <div class="row g-3 mb-4">
                        <?php foreach ($dynamic_features as $feat): ?>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 border d-flex align-items-center gap-3" style="background: var(--sec-light-bg); border-color: var(--card-border) !important;">
                                    <i class="fa-solid <?php echo $feat['icon']; ?> <?php echo $feat['color']; ?> fs-4"></i>
                                    <div>
                                        <h6 class="fw-bold mb-0" style="color: var(--text-heading);"><?php echo $feat['title']; ?></h6>
                                        <small class="text-muted"><?php echo $feat['desc']; ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- INQUIRY FORM COLUMN -->
        <div class="col-lg-5">
            <div class="card border rounded-4 p-4 p-md-5 sticky-top shadow-sm" style="top: 100px; background: var(--card-bg); border-color: var(--card-border) !important;">
                <h4 class="fw-extrabold mb-1" style="color: var(--text-heading);">
                    <i class="fa-solid fa-paper-plane text-primary me-2"></i>Inquire About Package
                </h4>
                <p class="text-muted small mb-4">Submit your requirement and our technical team will contact you directly.</p>

                <?php if (!empty($success_msg)): ?>
                    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 small mb-4">
                        <i class="fa-solid fa-circle-check me-1"></i> <?php echo $success_msg; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_msg)): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 small mb-4">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> <?php echo $error_msg; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label fw-bold small" style="color: var(--text-heading);">Your Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control custom-input" placeholder="e.g. Ali Khan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small" style="color: var(--text-heading);">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control custom-input" placeholder="name@company.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small" style="color: var(--text-heading);">Targeted Solution</label>
                        <input type="text" class="form-control custom-input fw-bold text-primary" value="<?php echo htmlspecialchars($service['title']); ?>" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small" style="color: var(--text-heading);">Project Requirements <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control custom-input" rows="4" placeholder="Mention your requirements or timeline..." required></textarea>
                    </div>

                    <button type="submit" name="submit_inquiry" class="btn btn-primary btn-lg w-100 rounded-3 fs-6 fw-bold shadow-sm">
                        <i class="fa-solid fa-paper-plane me-2"></i> Submit Inquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-input {
        background-color: var(--sec-light-bg) !important;
        border-color: var(--card-border) !important;
        color: var(--text-heading) !important;
    }
</style>

<?php include 'footer.php'; ?>
