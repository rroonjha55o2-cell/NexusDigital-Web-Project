<?php
// NexusDigital - Contact Page (Full Functional Backend & Modern UI)
include('db.php');
include('header.php'); 

$msg = "";
$prefilled_service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : NULL;
$prefilled_title = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '';

// Form submission logic with Database Insertion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);
    $service_id = !empty($_POST['service_id']) ? intval($_POST['service_id']) : "NULL";

    // Insert contact message linked to relational service_id
    $sql = "INSERT INTO contacts (service_id, name, email, phone, subject, message) 
            VALUES ($service_id, '$name', '$email', '$phone', '$subject', '$message')";
    
    if ($conn->query($sql)) {
        $msg = '<div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i><strong>Thank you!</strong> Your message has been saved successfully in the database.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Error saving message: ' . $conn->error . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}
?>

<!-- HERO HEADER SECTION -->
<section class="py-5 border-bottom" style="background: linear-gradient(135deg, var(--sec-light-bg) 0%, var(--sec-accent-bg) 100%);">
    <div class="container py-3 text-center">
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
            <i class="fa-solid fa-headset"></i> GET IN TOUCH
        </span>
        <h1 class="fw-extrabold display-5 mb-3" style="color: var(--text-heading);">Contact Our Engineering Team</h1>
        <p class="mx-auto fs-6 text-muted" style="max-width: 680px;">
            Send us an inquiry and our technical strategy team will review your requirements and get back to you shortly.
        </p>
    </div>
</section>

<div class="container py-5">
    
    <!-- DYNAMIC PHP ALERT MESSAGE -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <?php echo $msg; ?>
        </div>
    </div>

    <div class="row g-4">
        
        <!-- DIRECT CHANNELS COLUMN -->
        <div class="col-lg-5">
            <div class="p-4 p-md-5 rounded-4 border h-100 d-flex flex-column justify-content-between" style="background: var(--card-bg); border-color: var(--card-border) !important; box-shadow: var(--card-shadow);">
                <div>
                    <h4 class="fw-extrabold mb-4 d-flex align-items-center gap-2" style="color: var(--text-heading);">
                        <i class="fa-solid fa-paper-plane text-primary fs-5"></i> Direct Channels
                    </h4>
                    
                    <!-- Channel 1: Location -->
                    <div class="d-flex align-items-start gap-3 mb-4 p-3 rounded-3" style="background: var(--sec-light-bg);">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-location-dot fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Headquarters</h6>
                            <p class="small text-muted mb-0">Zarghoon Road, Opp. Serena Hotel, Quetta, Pakistan</p>
                        </div>
                    </div>

                    <!-- Channel 2: Email -->
                    <div class="d-flex align-items-start gap-3 mb-4 p-3 rounded-3" style="background: var(--sec-light-bg);">
                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-envelope fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Email Us</h6>
                            <a href="mailto:contact@nexusdigital.pk" class="small text-decoration-none text-muted">contact@nexusdigital.pk</a>
                        </div>
                    </div>

                    <!-- Channel 3: Phone -->
                    <div class="d-flex align-items-start gap-3 mb-4 p-3 rounded-3" style="background: var(--sec-light-bg);">
                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-phone fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Call Support</h6>
                            <a href="tel:+92812839102" class="small text-decoration-none text-muted">+92 (81) 283-9102</a>
                        </div>
                    </div>
                </div>

                <!-- Business Hours Box -->
                <div class="p-3 rounded-3 border border-primary border-opacity-20 bg-primary bg-opacity-10 text-primary text-center small fw-semibold mt-4">
                    <i class="fa-regular fa-clock me-1"></i> Business Hours: Mon - Sat (9:00 AM - 6:00 PM)
                </div>
            </div>
        </div>

        <!-- FORM COLUMN -->
        <div class="col-lg-7">
            <div class="p-4 p-md-5 rounded-4 border" style="background: var(--card-bg); border-color: var(--card-border) !important; box-shadow: var(--card-shadow);">
                <h4 class="fw-extrabold mb-4" style="color: var(--text-heading);">Send Us An Inquiry</h4>

                <form method="POST" action="contact.php">
                    <!-- Relational Service ID Hidden Input -->
                    <input type="hidden" name="service_id" value="<?php echo $prefilled_service_id; ?>">

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold" style="color: var(--text-heading);">Your Full Name <span class="text-danger">*</span></label>
                            <div class="input-group custom-input-group">
                                <span class="input-group-text border-end-0"><i class="fa-regular fa-user"></i></span>
                                <input type="text" name="name" class="form-control border-start-0 ps-0 custom-input" placeholder="e.g. Ali Raza" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold" style="color: var(--text-heading);">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group custom-input-group">
                                <span class="input-group-text border-end-0"><i class="fa-regular fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 ps-0 custom-input" placeholder="name@company.com" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold" style="color: var(--text-heading);">Phone Number</label>
                            <div class="input-group custom-input-group">
                                <span class="input-group-text border-end-0"><i class="fa-solid fa-phone-flip"></i></span>
                                <input type="text" name="phone" class="form-control border-start-0 ps-0 custom-input" placeholder="0300-1234567">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-bold" style="color: var(--text-heading);">Subject / Inquiry Target <span class="text-danger">*</span></label>
                            <div class="input-group custom-input-group">
                                <span class="input-group-text border-end-0"><i class="fa-solid fa-tag"></i></span>
                                <input type="text" name="subject" class="form-control border-start-0 ps-0 custom-input" value="<?php echo $prefilled_title ? 'Inquiry for ' . $prefilled_title : ''; ?>" placeholder="e.g. Custom PHP Web App" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-bold" style="color: var(--text-heading);">Message Details <span class="text-danger">*</span></label>
                            <textarea name="message" rows="5" class="form-control custom-input" placeholder="Describe your project requirements..." required></textarea>
                        </div>

                        <div class="col-md-12 pt-2">
                            <button type="submit" name="submit_contact" class="btn btn-primary btn-lg w-100 rounded-3 fs-6 fw-bold shadow-sm">
                                <i class="fa-solid fa-paper-plane me-2"></i> Submit Inquiry
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<style>
    .custom-input-group .input-group-text {
        background-color: var(--sec-light-bg) !important;
        border-color: var(--card-border) !important;
        color: var(--text-main) !important;
    }

    .custom-input {
        background-color: var(--sec-light-bg) !important;
        border-color: var(--card-border) !important;
        color: var(--text-heading) !important;
        padding: 10px 14px;
    }

    .custom-input:focus {
        background-color: var(--card-bg) !important;
        border-color: var(--brand-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15) !important;
    }
</style>

<?php include('footer.php'); ?>
