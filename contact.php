<?php
// NexusDigital - Contact Page
// Processes contact form submissions and saves messages to database

include('header.php'); 

$msg = "";
$prefilled_service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : NULL;
$prefilled_title = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '';

// Form submission logic
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
        $msg = "<div style='background: #dcfce7; color: #15803d; padding: 14px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;'>✓ Thank you! Your message has been saved successfully.</div>";
    } else {
        $msg = "<div style='background: #fee2e2; color: #b91c1c; padding: 14px; border-radius: 8px; margin-bottom: 20px;'>Error saving message: " . $conn->error . "</div>";
    }
}
?>

<div class="container" style="max-width: 800px;">
    <h1 class="page-title">Contact Our Team</h1>
    <p class="page-subtitle">Send us an inquiry and our team will get back to you shortly.</p>

    <?php echo $msg; ?>

    <div class="card">
        <form method="POST" action="contact.php">
            <input type="hidden" name="service_id" value="<?php echo $prefilled_service_id; ?>">

            <div class="form-group">
                <label>Your Full Name</label>
                <input type="text" name="name" class="form-control" required placeholder="e.g. Ali Raza">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required placeholder="name@company.com">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="0300-1234567">
                </div>
            </div>

            <div class="form-group">
                <label>Subject / Inquiry Target</label>
                <input type="text" name="subject" class="form-control" value="<?php echo $prefilled_title ? 'Inquiry for ' . $prefilled_title : ''; ?>" required placeholder="e.g. Custom PHP Web App">
            </div>

            <div class="form-group">
                <label>Message Details</label>
                <textarea name="message" class="form-control" rows="5" required placeholder="Describe your project requirements..."></textarea>
            </div>

            <button type="submit" name="submit_contact" class="btn-primary" style="width: 100%;">Submit Inquiry</button>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>
