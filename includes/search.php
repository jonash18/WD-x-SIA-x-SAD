<?php
$search = "";
$sql = "SELECT 
            d.*, 
            c.category_name, 
            w.website_name, 
            d.created_at AS date
        FROM documents d
        LEFT JOIN category c ON d.category_id = c.category_id
        LEFT JOIN website w ON d.website_id = w.website_id";


if (!empty($_GET['search'])) {
    $search = trim($_GET['search']);
    $sql .= " WHERE d.name LIKE ? 
              OR d.email LIKE ? 
              OR d.body LIKE ? 
              OR c.category_name LIKE ? 
              OR w.website_name LIKE ?
              OR d.doc_id LIKE ?
              OR d.mobile_number LIKE?"
              ;
}

$sql .= " ORDER BY d.created_at DESC";

$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $like = "%".$search."%";
    $stmt->bind_param("sssssss", $like, $like, $like, $like, $like, $like, $like);
}

$stmt->execute();
$result = $stmt->get_result();
?>