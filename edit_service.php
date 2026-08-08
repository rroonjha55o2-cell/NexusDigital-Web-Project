<?php
// NexusDigital - Edit Service Action
// Updates existing service data including title, price, category, and image
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id = intval($_GET['id']);
$serviceQuery = mysqli_query($conn, "SELECT * FROM services WHERE id = $id");
$service = mysqli_fetch_assoc($serviceQuery);

if (!$service) {
    echo "Service not found!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category_id = intval($_POST['category_id']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $imageName = $service['image'];

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $imageName = $fileName;
        }
    }

    $updateQuery = "UPDATE services SET 
                    title = '$title', 
                    category_id = $category_id, 
                    description = '$description', 
                    price = $price, 
                    image = '$imageName' 
                    WHERE id = $id";

    if (mysqli_query($conn, $updateQuery)) {
        header("Location: admin_dashboard.php?msg=updated");
        exit();
    } else {
        $error = "Error updating service: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Service - Admin Panel</title>
    <style>
        body { font-family: sans-serif; background: #f8fafc; padding: 30px; }
        .form-card { max-width: 600px; margin: 0 auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #334155; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; }
        .btn { background: #2563eb; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-cancel { background: #64748b; text-decoration: none; padding: 10px 20px; color: white; border-radius: 6px; font-size: 14px; margin-left: 10px; }
    </style>
</head>
<body>

<div class="form-card">
    <h2>✏️ Edit Service</h2>
    <form method="POST" enctype="multipart/form-data" style="margin-top: 15px;">
        <div class="form-group">
            <label>Service Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($service['title']); ?>" required>
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category_id" required>
                <?php
                $catQuery = mysqli_query($conn, "SELECT * FROM categories");
                while ($cat = mysqli_fetch_assoc($catQuery)) {
                    $selected = ($cat['id'] == $service['category_id']) ? 'selected' : '';
                    echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" required><?php echo htmlspecialchars($service['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Price (PKR)</label>
            <input type="number" step="0.01" name="price" value="<?php echo $service['price']; ?>" required>
        </div>

        <div class="form-group">
            <label>Current Image</label><br>
            <?php 
            $currentImg = filter_var($service['image'], FILTER_VALIDATE_URL) ? $service['image'] : 'uploads/' . $service['image'];
            ?>
            <img src="<?php echo $currentImg; ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px; margin-bottom: 10px;">
            <input type="file" name="image" accept="image/*">
            <small style="color: #64748b; display: block; margin-top: 5px;">(Nayi image upload karenge toh purani replace ho jayegi)</small>
        </div>

        <button type="submit" class="btn">Update Service</button>
        <a href="admin_dashboard.php" class="btn-cancel">Cancel</a>
    </form>
</div>

</body>
</html>
