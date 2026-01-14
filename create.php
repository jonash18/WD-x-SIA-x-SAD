<?php
include 'connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $mobile   = $_POST['mobile_number'] ?? '';
    $body     = $_POST['body'] ?? '';
    $website  = $_POST['website_name'] ?? '';
    $category = $_POST['category_name'] ?? '';

    // Check duplicate
    $check = $conn->prepare("SELECT 1 FROM documents WHERE name=? AND email=? AND body=?");
    $check->bind_param("sss", $name, $email, $body);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Duplicate entry"]);
        exit;
    }
    $check->close();

    $stmt = $conn->prepare("
        INSERT INTO documents (name, email, mobile_number, body, website_id, category_id)
        VALUES (?, ?, ?, ?, 
            (SELECT website_id FROM website WHERE website_name=?), 
            (SELECT category_id FROM category WHERE category_name=?))
    ");
    $stmt->bind_param("ssssss", $name, $email, $mobile, $body, $website, $category);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        include 'email.php';
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>