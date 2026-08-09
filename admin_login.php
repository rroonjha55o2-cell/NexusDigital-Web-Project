<?php
// NexusDigital - Admin Login Panel
session_start();
include('db.php');

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Custom Admin Credentials Verification
    if ($username === 'Abdul rehman' && $password === 'rehman5502') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = 'Ghalat Username ya Password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - NexusDigital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f172a;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }
        .login-card {
            background-color: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 2rem;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }
        .form-control {
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #ffffff;
        }
        .form-control:focus {
            background-color: #0f172a;
            border-color: #3b82f6;
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }
        .form-control::placeholder {
            color: #64748b;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center fw-bold mb-4">Admin Portal</h3>

    <?php if($error): ?>
        <div class="alert alert-danger py-2 small text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label small text-secondary fw-semibold">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Username" required autocomplete="off">
        </div>
        <div class="mb-4">
            <label class="form-label small text-secondary fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">Login to Dashboard</button>
    </form>
</div>

</body>
</html>
