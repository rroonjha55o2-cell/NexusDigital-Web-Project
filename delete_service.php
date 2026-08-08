<?php
// NexusDigital - Delete Service Action
// Processes deletion of selected service entries from MySQL database
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $imgQuery = mysqli_query($conn, "SELECT image FROM services WHERE id = $id");
    $imgData = mysqli_fetch_assoc($imgQuery);
    if ($imgData && !filter_var($imgData['image'], FILTER_VALIDATE_URL) && !empty($imgData['image'])) {
        $filePath = 'uploads/' . $imgData['image'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $query = "DELETE FROM services WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: admin_dashboard.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
