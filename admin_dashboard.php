<?php
// NexusDigital - Admin Management Panel
// Handles full CRUD operations (Add, Edit, Delete) for services

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
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image_name);
        } else {
            $error = 'Invalid image format. Allowed: JPG, PNG, WEBP';
        }
    }

    if (empty($error)) {
        $stmt = $conn->prepare("INSERT INTO services (category_id, title, description, price, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issds", $category_id, $title, $description, $price, $image_name);
        if ($stmt->execute()) {
            $message = "New service added successfully!";
        } else {
            $error = "Error adding service: " . $conn->error;
        }
    }
}

// Fetch categories & services
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
$services = $conn->query("SELECT s.*, c.name as category_name FROM services s LEFT JOIN categories c ON s.category_id = c.id ORDER BY s.id DESC");
$contacts = $conn->query("SELECT * FROM contacts ORDER BY id DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NexusDigital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
        <span class="navbar-brand fw-bold"><i class="fa-solid fa-user-shield text-info me-2"></i>NexusDigital Admin Panel</span>
        <div class="d-flex align-items-center gap-2">
            <!-- POINT 3: Direct Website Access Button -->
            <a href="index.php" target="_blank" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-globe me-1"></i> View Live Website</a>
            <a href="logout.php" class="btn btn-danger btn-sm"><i class="fa-solid fa-right-from-bracket me-1"></i> Logout</a>
        </div>
    </div>
</nav>

<div class="container my-4">
    <?php if($message): ?>
        <div class="alert alert-success alert-dismissible fade show"><?php echo $message; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="alert alert-danger alert-dismissible fade show"><?php echo $error; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-white fw-bold"><i class="fa-solid fa-plus-circle text-primary me-2"></i>Add New Service / Product (Image Upload Supported)</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Enterprise Cloud Deployment" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category (Relational Foreign Key)</label>
                        <select name="category_id" class="form-select" required>
                            <?php while($cat = $categories->fetch_assoc()): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Write enterprise service details..." required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (PKR)</label>
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="75000" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Service Image File</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12">
                        <button type="submit" name="add_service" class="btn btn-primary fw-semibold"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload & Add Service</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<!-- Active Services Table with Actions -->
<div class="card" style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <h3 style="margin-bottom: 15px; color: #1e293b;">📋 Active Services List</h3>
    <!-- Added responsive wrapper so table doesn't break out on mobile screens -->
    <div class="table-responsive">
        <table style="width: 100%; min-width: 600px; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-size: 13px;">
                    <th style="padding: 10px;">Image</th>
                    <th style="padding: 10px;">Title</th>
                    <th style="padding: 10px;">Category</th>
                    <th style="padding: 10px;">Price</th>
                    <th style="padding: 10px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once 'db.php';
                $query = "SELECT services.*, categories.name as category_name 
                          FROM services 
                          LEFT JOIN categories ON services.category_id = categories.id 
                          ORDER BY services.id DESC";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $imgSrc = !empty($row['image']) 
                            ? (filter_var($row['image'], FILTER_VALIDATE_URL) ? $row['image'] : 'uploads/' . $row['image'])
                            : 'https://via.placeholder.com/60x60?text=No+Img';
                        ?>
                        <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px;">
                            <td style="padding: 10px;">
                                <img src="<?php echo $imgSrc; ?>" alt="service" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                            </td>
                            <td style="padding: 10px; font-weight: 600; color: #0f172a;"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td style="padding: 10px;"><span style="background: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; white-space: nowrap;"><?php echo htmlspecialchars($row['category_name']); ?></span></td>
                            <td style="padding: 10px; font-weight: 700; color: #16a34a; white-space: nowrap;">Rs. <?php echo number_format($row['price']); ?></td>
                            <td style="padding: 10px; text-align: center; white-space: nowrap;">
                                <a href="edit_service.php?id=<?php echo $row['id']; ?>" style="background: #2563eb; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; margin-right: 5px; display: inline-block;">Edit</a>
                                <a href="delete_service.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Kiya aap is service ko delete karna chahte hain?');" style="background: #dc2626; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-block;">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center; padding: 15px; color: #64748b;'>No services found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

    <!-- Recent Customer Inquiries -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold"><i class="fa-solid fa-envelope-open-text text-warning me-2"></i>Recent Customer Inquiries</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($contacts && $contacts->num_rows > 0): ?>
                            <?php while($c = $contacts->fetch_assoc()): ?>
                                <tr>
                                    <td class="fw-bold"><?php echo htmlspecialchars($c['name']); ?></td>
                                    <td><?php echo htmlspecialchars($c['email']); ?></td>
                                    <td><?php echo htmlspecialchars($c['subject']); ?></td>
                                    <td class="small"><?php echo htmlspecialchars($c['message']); ?></td>
                                    <td class="small text-muted"><?php echo $c['created_at'] ?? 'Recent'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-3 text-muted">No customer inquiries found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
