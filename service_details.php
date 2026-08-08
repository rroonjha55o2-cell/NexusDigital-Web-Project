<?php
// NexusDigital - Service Details View
// Displays complete single service information and booking prompt
include 'db.php';
include 'header.php';

$service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Database se service aur uski category fetch karna
$query = "SELECT services.*, categories.name AS category_name 
          FROM services 
          LEFT JOIN categories ON services.category_id = categories.id 
          WHERE services.id = $service_id";
$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    echo "<div class='container my-5 text-center'>
            <h2>Service Not Found</h2>
            <p>Aap ki talash karda service maujood nahi hai.</p>
            <a href='services.php' class='btn btn-primary'>View All Services</a>
          </div>";
    include 'footer.php';
    exit();
}

$service = $result->fetch_assoc();

// Inquiry Form Handle Karna
$success_msg = "";
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_inquiry'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string("Inquiry for: " . $service['title']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        $success_msg = "Aap ki inquiry mosool ho gayi hai! Hum jald aap se rabta karenge.";
    } else {
        $error_msg = "Inquiry bhejney mein masla hua: " . $conn->error;
    }
}
?>

<div class="container py-5">
    <a href="index.php" class="btn btn-outline-secondary btn-sm mb-4">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Home
    </a>

    <div class="row g-4">
        <!-- Service Details (Left Side) -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <?php if (!empty($service['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($service['image']); ?>" 
                         class="img-fluid w-100" style="max-height: 380px; object-fit: cover;" 
                         alt="<?php echo htmlspecialchars($service['title']); ?>">
                <?php endif; ?>
                <div class="card-body p-4">
                    <span class="badge bg-primary mb-2 px-3 py-2 fs-6">
                        <?php echo htmlspecialchars($service['category_name'] ?? 'General'); ?>
                    </span>
                    <h2 class="fw-bold text-dark mt-2 mb-3"><?php echo htmlspecialchars($service['title']); ?></h2>
                    
                    <div class="mb-4">
                        <span class="text-muted fs-5">Starting Price: </span>
                        <span class="fs-3 fw-bold text-success">Rs. <?php echo number_format($service['price']); ?></span>
                    </div>

                    <h5 class="fw-bold border-bottom pb-2 mb-3">Service Description & Details</h5>
                    <p class="text-secondary style-description" style="line-height: 1.8; font-size: 16px;">
                        <?php echo nl2br(htmlspecialchars($service['description'])); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Direct Inquiry Form (Right Side) -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 90px; background-color: #f8fafc;">
                <h4 class="fw-bold mb-1">Inquire About This Service</h4>
                <p class="text-muted small mb-4">Fill out the form below to get a quote or details for this service.</p>

                <?php if (!empty($success_msg)): ?>
                    <div class="alert alert-success alert-dismissible fade show"><?php echo $success_msg; ?></div>
                <?php endif; ?>

                <?php if (!empty($error_msg)): ?>
                    <div class="alert alert-danger alert-dismissible fade show"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Ali Khan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Selected Service</label>
                        <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($service['title']); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Message / Requirements</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Write your requirements or questions here..." required></textarea>
                    </div>

                    <button type="submit" name="submit_inquiry" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="fa-solid fa-paper-plane me-2"></i> Send Inquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
