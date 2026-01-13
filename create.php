<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $mobile   = $_POST['mobile_number'] ?? '';
    $body     = $_POST['body'] ?? '';
    $website  = $_POST['website_name'] ?? '';
    $category = $_POST['category_name'] ?? '';

    // 1. Insert into database
    $stmt = $conn->prepare("
        INSERT INTO documents (name, email, mobile_number, body, website_id, category_id)
        VALUES (?, ?, ?, ?, 
            (SELECT website_id FROM website WHERE website_name=?), 
            (SELECT category_id FROM category WHERE category_name=?))
    ");
    $stmt->bind_param("ssssss", $name, $email, $mobile, $body, $website, $category);
    mysqli_report(MYSQLI_REPORT_OFF);

    if ($stmt->execute()) {
        // ✅ Only redirect after successful insert
        header("Location: incoming.php?success=1");
        exit;
    } else {
        if ($stmt->errno == 1062) {
            header("Location: incoming.php?duplicate=1");
            exit;
        } else {
            echo "Error: " . htmlspecialchars($stmt->error);
        }
    }

    include 'email.php';
    $stmt->close();
    $conn->close();
}
?>