<?php
// NexusDigital - Enterprise Admin Login Portal
session_start();
require_once 'db.php';

// If already logged in, redirect directly to admin dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Default credentials check
    if (($username === 'admin' && $password === 'admin123') || ($username === 'admin' && $password === 'admin')) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Fallback Database Check
        $db_authenticated = false;
        if (isset($conn) && $conn) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param("ss", $username, $username);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($res && $res->num_rows > 0) {
                    $user = $res->fetch_assoc();
                    if (password_verify($password, $user['password']) || $password === $user['password']) {
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['admin_user'] = $user['username'];
                        $db_authenticated = true;
                        header("Location: admin_dashboard.php");
                        exit();
                    }
                }
            }
        }
        
        if (!$db_authenticated) {
            $error = "Invalid Username or Password! (Default: admin / admin123)";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - NexusDigital</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #2563eb;
            --brand-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --body-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-heading: #0f172a;
            --text-muted: #64748b;
            --input-bg: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--body-bg);
            background-image: 
                radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.06) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(79, 70, 229, 0.06) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
            width: 100%;
            max-width: 420px;
            padding: 40px 32px;
            transition: all 0.3s ease;
        }

        .brand-logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-heading);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .form-control {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            color: var(--text-heading);
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .input-group-text {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: var(--text-muted);
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--brand-primary);
            color: var(--brand-primary);
            background-color: #ffffff;
        }

        .btn-brand {
            background: var(--brand-gradient);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
            transition: all 0.3s ease;
        }

        .btn-brand:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
            color: #ffffff;
        }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: var(--brand-primary);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <div class="brand-logo mb-2">
            <i class="fa-solid fa-shield-halved text-primary fs-2"></i>
            <span>Nexus<span class="text-primary">Digital</span></span>
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold small">
            <i class="fa-solid fa-lock me-1"></i> Admin Portal Access
        </span>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger d-flex align-items-center rounded-3 py-2 px-3 mb-4 small fw-semibold border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2 fs-6"></i>
            <div><?php echo htmlspecialchars($error); ?></div>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label fw-bold small text-dark mb-1">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Enter admin username" required autocomplete="off">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold small text-dark mb-1">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
        </div>

        <button type="submit" name="login" class="btn btn-brand w-100 mb-3">
            <i class="fa-solid fa-right-to-bracket me-2"></i> Login to Dashboard
        </button>
    </form>

    <div class="text-center pt-2">
        <a href="index.php" class="back-link">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Live Website
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
