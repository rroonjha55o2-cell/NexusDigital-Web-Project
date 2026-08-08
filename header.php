<?php
// NexusDigital - Global Header Component
// Renders website header, navigation menu, and meta branding
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusDigital - Enterprise Web & Software Solutions</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            color: #1e293b;
        }
        .navbar {
            background-color: #0f172a !important;
            padding: 15px 0;
            border-bottom: 1px solid #1e293b;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 22px;
            color: #ffffff !important;
        }
        .navbar-brand span {
            color: #3b82f6;
        }
        .nav-link {
            color: #94a3b8 !important;
            font-weight: 500;
            margin: 0 8px;
            transition: color 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
        }
        .btn-admin {
            background: #2563eb;
            color: #ffffff !important;
            border-radius: 6px;
            padding: 8px 18px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        .btn-admin:hover {
            background: #1d4ed8;
            color: #ffffff !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Nexus <span>Digital</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a href="admin_login.php" class="btn-admin"><i class="fa-solid fa-lock me-1"></i> Admin Portal</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
