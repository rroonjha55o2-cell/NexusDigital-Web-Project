<?php
// NexusDigital - Enterprise Delete Service Action Handler
session_start();
include('db.php');

// Admin Session Guard - Prevents direct URL deletion attempts
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id > 0) {
        // 1. Fetch existing image path securely
        $stmt = $conn->prepare("SELECT image FROM services WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $service = $result->fetch_assoc();
            $image = $service['image'];

            // Remove uploaded thumbnail from server directory if it exists
            if (!empty($image) && !filter_var($image, FILTER_VALIDATE_URL)) {
                $filePath = 'uploads/' . basename($image);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            // 2. Delete database record
            $delete_stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                header("Location: admin_dashboard.php?msg=deleted");
                exit();
            } else {
                header("Location: admin_dashboard.php?error=delete_failed");
                exit();
            }
        }
    }
}

// Fallback redirect if ID is missing or invalid
header("Location: admin_dashboard.php");
exit();
?>
