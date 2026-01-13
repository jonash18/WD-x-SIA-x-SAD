<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doc_id'])) {
    $doc_id = intval($_POST['doc_id']);

    $stmt = $conn->prepare("DELETE FROM documents WHERE doc_id = ?");
    $stmt->bind_param("i", $doc_id);

    if ($stmt->execute()) {
        header("Location: adminLogin.php?status=deleted");
        exit();
    } else {
        header("Location: adminLogin.php?status=error");
        exit();
    }
}
?>