<?php
// NexusDigital - Global Footer Component
// Renders global website footer, quick links, and contact information
?>
<footer class="bg-dark text-light pt-5 pb-4 mt-5 border-top border-secondary">

<footer class="bg-dark text-light pt-5 pb-4 mt-5 border-top border-secondary">
    <div class="container">
        <div class="row g-4">
            <!-- Col 1: Brand Info -->
            <div class="col-lg-4 col-md-6">
                <h4 class="text-white fw-bold mb-3"><i class="fa-solid fa-cube text-info me-2"></i>Nexus<span class="text-info">Digital</span></h4>
                <p class="text-secondary small pe-lg-3">
                    NexusDigital is a premier software engineering firm delivering scalable web applications, custom enterprise solutions, high-availability database architectures, and cloud services for modern businesses.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-secondary fs-5"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-secondary fs-5"><i class="fab fa-github"></i></a>
                    <a href="#" class="text-secondary fs-5"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <!-- Col 2: Navigation Links -->
            <div class="col-lg-2 col-md-6">
                <h6 class="text-uppercase text-white fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="index.php" class="text-secondary text-decoration-none">Home Page</a></li>
                    <li class="mb-2"><a href="about.php" class="text-secondary text-decoration-none">About Company</a></li>
                    <li class="mb-2"><a href="services.php" class="text-secondary text-decoration-none">Services & Pricing</a></li>
                    <li class="mb-2"><a href="contact.php" class="text-secondary text-decoration-none">Get In Touch</a></li>
                    <li class="mb-2"><a href="admin_login.php" class="text-secondary text-decoration-none">Admin Login</a></li>
                </ul>
            </div>

            <!-- Col 3: Core Capabilities -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase text-white fw-bold mb-3">Core Expertise</h6>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-2"><i class="fa-solid fa-angle-right me-2 text-info"></i>Web Application Engineering</li>
                    <li class="mb-2"><i class="fa-solid fa-angle-right me-2 text-info"></i>Enterprise ERP/CRM Systems</li>
                    <li class="mb-2"><i class="fa-solid fa-angle-right me-2 text-info"></i>MySQL Database Architecture</li>
                    <li class="mb-2"><i class="fa-solid fa-angle-right me-2 text-info"></i>Cloud Infrastructure & DevOps</li>
                    <li class="mb-2"><i class="fa-solid fa-angle-right me-2 text-info"></i>UI/UX Product Strategy</li>
                </ul>
            </div>

            <!-- Col 4: Quetta Address & Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase text-white fw-bold mb-3">Headquarters</h6>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fa-solid fa-location-dot me-3 mt-1 text-info fs-6"></i>
                        <span>Suite 402, Executive Tech Tower, Zarghoon Road, Opp. Serena Hotel, Quetta, Balochistan, Pakistan</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center">
                        <i class="fa-solid fa-phone me-3 text-info"></i>
                        <span>+92 (81) 283-9102 / +92 300 1234567</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center">
                        <i class="fa-solid fa-envelope me-3 text-info"></i>
                        <span>contact@nexusdigital.pk</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fa-solid fa-clock me-3 text-info"></i>
                        <span>Mon - Sat: 9:00 AM - 6:00 PM</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="row align-items-center small text-secondary">
            <div class="col-md-6 text-center text-md-start">
                &copy; <?php echo date("Y"); ?> NexusDigital Software Solutions. All rights reserved.
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <a href="#" class="text-secondary text-decoration-none me-3">Privacy Policy</a>
                <a href="#" class="text-secondary text-decoration-none me-3">Terms of Service</a>
                <a href="#" class="text-secondary text-decoration-none">SLA Agreement</a>
            </div>
        </div>
    </div>
</footer>

<script href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
