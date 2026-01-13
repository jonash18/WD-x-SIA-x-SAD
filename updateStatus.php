<?php
include 'connect.php'; 

$doc_id = $_POST['doc_id'] ?? null;
$status = $_POST['status'] ?? null;

if ($doc_id && $status) {
    $stmt = $conn->prepare("UPDATE documents SET status = ? WHERE doc_id = ?");
    if ($stmt->execute([$status, $doc_id])) {
        echo "Status updated to $status";
    } else {
        echo "DB update failed";
    }
} else {
    echo "Missing parameters";
}
?>