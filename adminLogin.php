<?php
session_start();

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

$admin_user = "admin";
$admin_pass = "12345";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
        $_SESSION['admin'] = $_POST['username'];
    } else {
        $error = "Invalid username or password!";
    }
}

if (!isset($_SESSION['admin'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Admin Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: url('bgimg.jpg') no-repeat center center fixed;
                background-size: cover;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-radius: 12px;
                padding: 30px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
                color: #fff;
                width: 350px;
            }
        </style>
    </head>

    <body>
        <div class="glass-card">
            <h2 class="text-center mb-4">Admin Login</h2>
            <?php if (!empty($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>
                <button type="button" class="btn btn-primary w-100" onclick="window.location.href='dashboard.php';">Go back to Dashboard</button>
            </form>
        </div>
    </body>

    </html>
<?php
    exit();
}
require_once 'connect.php';
$sql = "SELECT d.doc_id, 
       d.name, 
       d.email, 
       d.body, 
       d.mobile_number, 
       d.status, 
       d.created_at, 
       d.website_id, 
       d.category_id, 
       c.category_name
FROM documents d
LEFT JOIN category c 
       ON d.category_id = c.category_id
";

$result = $conn->query($sql);
?>
<?php include 'includes/adminDashboard.php'; ?>
<?php $conn->close(); ?>