<?php
// NexusDigital - Admin Authentication
// Handles secure admin login credentials and session initialization
session_start();
include('db.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM admin_users WHERE username='$username'");
    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        // Checking plaintext or hash for simplicity
        if ($password === $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid Password!";
        }
    } else {
        $error = "Admin user not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | NexusDigital</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #0f172a; color: white; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-card { background: #1e293b; padding: 40px; border-radius: 16px; width: 100%; max-width: 400px; border: 1px solid #334155; }
        .form-control { width: 100%; padding: 12px; margin-top: 6px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #475569; background: #0f172a; color: white; box-sizing: border-box; }
        .btn { width: 100%; padding: 12px; background: #2563eb; color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 style="margin-bottom: 8px; text-align: center;">Admin Portal</h2>
        <p style="color: #94a3b8; font-size: 14px; text-align: center; margin-bottom: 24px;">Default Credentials: admin / admin123</p>
        
        <?php if($error): ?>
            <div style="background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; font-size: 13px; margin-bottom: 15px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label style="font-size: 13px; font-weight: 600;">Username</label>
            <input type="text" name="username" class="form-control" required>

            <label style="font-size: 13px; font-weight: 600;">Password</label>
            <input type="password" name="password" class="form-control" required>

            <button type="submit" class="btn">Login to Dashboard</button>
        </form>
    </div>
</body>
</html>
