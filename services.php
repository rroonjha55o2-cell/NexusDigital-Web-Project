<?php
// NexusDigital - Services Suite (Clean & Dynamic Layout)
include 'db.php';
include 'header.php';

$all_services = $conn->query("SELECT services.*, categories.name AS category_name 
                             FROM services 
                             LEFT JOIN categories ON services.category_id = categories.id 
                             ORDER BY services.id DESC");
?>

<!-- HERO SECTION -->
<section class="py-5 border-bottom" style="background: linear-gradient(135deg, var(--sec-light-bg) 0%, var(--sec-accent-bg) 100%);">
    <div class="container py-3 text-center">
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
            <i class="fa-solid fa-layer-group"></i> CAPABILITIES & SOLUTIONS
        </span>
        <h1 class="fw-extrabold display-5 mb-3" style="color: var(--text-heading);">Our Software Services</h1>
        <p class="mx-auto fs-6 text-muted" style="max-width: 680px;">
            Explore our complete suite of custom software solutions, database architectures, and web development capabilities.
        </p>
    </div>
</section>

<!-- MAIN SERVICES GRID SECTION -->
<div class="container py-5">
    <div class="row g-4">
        <?php if ($all_services && $all_services->num_rows > 0): ?>
            <?php while ($row = $all_services->fetch_assoc()): ?>
                <?php 
                    $imgSrc = '';
                    if (!empty($row['image'])) {
                        $imgSrc = filter_var($row['image'], FILTER_VALIDATE_URL) ? $row['image'] : 'uploads/' . $row['image'];
                    }
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-service h-100 border rounded-4 overflow-hidden shadow-sm d-flex flex-column" style="background: var(--card-bg); border-color: var(--card-border) !important;">
                        <?php if (!empty($imgSrc)): ?>
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" class="card-img-top" style="height: 220px; object-fit: cover;" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <?php else: ?>
                            <div class="bg-secondary bg-opacity-10 text-muted d-flex align-items-center justify-content-center" style="height: 220px;">
                                <i class="fa-solid fa-laptop-code fa-4x opacity-50"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="badge bg-primary bg-opacity-10 text-primary w-auto align-self-start mb-3 px-3 py-2 rounded-pill fw-bold small">
                                <i class="fa-solid fa-tag me-1"></i> <?php echo htmlspecialchars($row['category_name'] ?? 'Software Engineering'); ?>
                            </span>
                            
                            <h5 class="fw-extrabold mb-2" style="color: var(--text-heading);"><?php echo htmlspecialchars($row['title']); ?></h5>
                            
                            <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                                <?php 
                                    $desc = htmlspecialchars($row['description']);
                                    echo (strlen($desc) > 130) ? substr($desc, 0, 130) . '...' : $desc;
                                ?>
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top" style="border-color: var(--card-border) !important;">
                                <div>
                                    <span class="text-muted d-block extra-small text-uppercase fw-bold">Starting At</span>
                                    <span class="fw-extrabold text-success fs-5">Rs. <?php echo number_format($row['price']); ?></span>
                                </div>
                                <a href="service_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm px-3 py-2 rounded-3 fw-bold shadow-sm">
                                    View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="p-5 card border rounded-4" style="background: var(--card-bg); border-color: var(--card-border) !important;">
                    <i class="fa-solid fa-folder-open fa-3x text-muted mb-3 opacity-50"></i>
                    <h5 class="fw-bold" style="color: var(--text-heading);">No Services Available</h5>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .card-service {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-service:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
    }
</style>

<?php include 'footer.php'; ?>
