<?php
// NexusDigital - Services Page
// Fetches and displays all active services from MySQL database
include 'db.php';
include 'header.php';

// Tamam services fetch karna
$all_services = $conn->query("SELECT services.*, categories.name AS category_name 
                             FROM services 
                             LEFT JOIN categories ON services.category_id = categories.id 
                             ORDER BY services.id DESC");
?>

<div class="bg-light py-5 border-bottom mb-4">
    <div class="container text-center py-2">
        <h1 class="fw-bold text-dark mb-2">Our Software Services</h1>
        <p class="text-secondary mb-0" style="max-width: 600px; margin: 0 auto;">
            Explore our complete suite of enterprise digital capabilities, high-performance database architectures, and custom software systems.
        </p>
    </div>
</div>

<div class="container py-4 mb-5">
    <div class="row g-4">
        <?php if ($all_services && $all_services->num_rows > 0): ?>
            <?php while ($row = $all_services->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <?php if (!empty($row['image'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <?php else: ?>
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fa-solid fa-laptop-code fa-3x opacity-50"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="badge bg-primary text-white w-auto align-self-start mb-2 px-3 py-1">
                                <?php echo htmlspecialchars($row['category_name'] ?? 'General'); ?>
                            </span>
                            <h5 class="fw-bold text-dark"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="text-secondary small flex-grow-1">
                                <?php 
                                    $desc = htmlspecialchars($row['description']);
                                    echo (strlen($desc) > 100) ? substr($desc, 0, 100) . '...' : $desc;
                                ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <div>
                                    <span class="text-muted d-block small">Price</span>
                                    <span class="fw-bold text-dark">Rs. <?php echo number_format($row['price']); ?></span>
                                </div>
                                <a href="service_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm px-3 fw-semibold rounded-3">
                                    <i class="fa-solid fa-eye me-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Koi service available nahi hai.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
