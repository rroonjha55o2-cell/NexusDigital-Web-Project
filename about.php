<?php
// NexusDigital - About Us Page
// Provides company background, mission, vision, and core capabilities
include('header.php'); ?>
<div class="container">
    <h1 class="page-title">About Our Agency</h1>
    <p class="page-subtitle">Learn about our technical stack and development philosophies.</p>
   <div class="card" style="margin-bottom: 40px; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white;">
        <h2 style="font-size: 26px; font-weight: 800; margin-bottom: 12px;">Building Modern Software Architecture</h2>
        <p style="font-size: 16px; opacity: 0.9;">NexusDigital is a dedicated development firm specializing in custom PHP application development and secure database systems. We transform complex client needs into robust digital platforms.</p>
    </div>

    <h2 style="font-size: 22px; font-weight: 700; margin-bottom: 20px;">Technical Stack & Capabilities</h2>
    <div class="grid">
        <div class="card">
            <h3 style="font-size: 18px; color: #2563eb;">Full-Stack PHP</h3>
            <p style="font-size: 14px; color: #64748b;">Dynamic routing, session security, authentication logic, and file handling.</p>
        </div>
        <div class="card">
            <h3 style="font-size: 18px; color: #2563eb;">MySQL Relational DB</h3>
            <p style="font-size: 14px; color: #64748b;">Data normalization, table constraints, relational indexes, and SQL security.</p>
        </div>
        <div class="card">
            <h3 style="font-size: 18px; color: #2563eb;">Admin Control Panel</h3>
            <p style="font-size: 14px; color: #64748b;">Comprehensive CRUD features (Create, Read, Update, Delete) for complete content control.</p>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
