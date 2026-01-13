<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['website_id']);
    $name = $conn->real_escape_string($_POST['website_name']);

    $update = "UPDATE website SET website_name='$name' WHERE website_id=$id";
    if ($conn->query($update) === TRUE) {
        header("Location: adminLogin.php?status=success");
        exit();
    } else {
        header("Location: adminLogin.php?status=error");
        exit();
    }
}
?>