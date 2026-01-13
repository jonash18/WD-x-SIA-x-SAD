<?php
include 'connect.php';

$docId = $_GET['doc_id'] ?? null;
$doc = null;

if ($docId) {
  $stmt = $conn->prepare("
        SELECT 
            c.category_id,
            c.category_name,
            w.website_id,
            w.website_name,
            d.doc_id,
            d.name,
            d.email,
            d.mobile_number,
            d.body,
            d.status,
            d.created_at AS created_at
        FROM documents d
        LEFT JOIN category c ON d.category_id = c.category_id
        LEFT JOIN website w ON d.website_id = w.website_id
        WHERE d.doc_id = ?
        LIMIT 1
    ");
  $stmt->bind_param("s", $docId); // UUID is string
  $stmt->execute();
  $result = $stmt->get_result();
  $doc = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Document Viewer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php include 'includes/bgcolor.html'; ?>

<!-- Exit button fixed top-left -->
<div class="d-flex justify-content-end align-items-end p-3 top-0 start-0">
  <button type="button" class="btn btn-light btn-sm border" onclick="window.history.back();">Close</button>
</div>

<div class="container-fluid mb-5">
  <?php if ($doc) { ?>
    <div class="card shadow-lg mb-4" style="max-width: 90%; margin: auto; font-size: 1.1rem;">
      <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center" style="font-size: 1.3rem;">
        <span>Document Viewer</span>
        <span class="badge bg-warning text-dark fs-6">
          <?= htmlspecialchars(ucfirst($doc['category_name'] ?? 'Unknown')); ?>
        </span>
      </div>

      <div class="card-body p-5">
        <!-- Sender Info -->
        <div class="row mb-4">
          <div class="col-md-6">
            <p><strong>Sender:</strong> <?= htmlspecialchars($doc['name']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($doc['email']); ?></p>
            <p><strong>Mobile:</strong> <?= htmlspecialchars($doc['mobile_number']); ?></p>
          </div>
          <div class="col-md-6 text-md-end">
            <p><strong>Date:</strong> <?= htmlspecialchars($doc['created_at']); ?></p>
            <p><strong>Website:</strong> <?= htmlspecialchars($doc['website_name']); ?></p>
            <p><strong>Status:</strong>
              <span class="badge <?= ($doc['status'] ?? '') === 'open' ? 'bg-success' : 'bg-secondary'; ?> fs-6">
                <?= htmlspecialchars($doc['status'] ?? 'unknown'); ?>
              </span>
            </p>
          </div>
        </div>

        <div class="border rounded-3 p-4 mb-5 bg-white shadow-sm">
          <h4 class="fw-bold dark mb-3">Document ID: <?= htmlspecialchars($doc['doc_id']); ?></h4>
          <div class="fs-5 lh-lg text-secondary">
            <?= nl2br(htmlspecialchars($doc['body'])); ?>
          </div>
        </div>

        <?php include 'includes/aiPanel.html'; ?>

        <?php include 'includes/reply.php'; ?>
      </div>
    </div>
  <?php } else { ?>
    <div class="alert alert-danger">Document not found.</div>
  <?php } ?>
</div>


<script type="module">
  import {
    summarizeDocument
  } from './aiAPI.js';
  window.summarizeDocument = summarizeDocument;

 
</script>





</script>
</body>

</html>