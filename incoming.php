<?php
$tabName = "Incoming";

// 🔹 First API (ISC Student Organization System)
$jsonUrl1  = "https://unsatirical-sharda-calorimetric.ngrok-free.dev/ISC-Student-Organization-System/api-connections/sharedFeedbacks-api.php";
$jsonData1 = @file_get_contents($jsonUrl1);
$complaints1 = json_decode($jsonData1, true);

// 🔹 Second API (CampusWear)
$jsonUrl2  = "https://coletta-parecious-improperly.ngrok-free.dev/CampusWear/api/shared/feedback.php";
$jsonData2 = @file_get_contents($jsonUrl2);
$complaints2 = json_decode($jsonData2, true);

$file = 'reports.json';
$reports = [];

// 🔹 Remap ISC API fields
$mapped1 = array_map(function ($r) {
  return [
    'feedback_id'   => $r['fbID'] ?? '',
    'user_id'       => $r['mbID'] ?? '0', 
    'name'          => $r['fbName'] ?? '',
    'email'         => $r['mbEmail'] ?? '',
    'mobile_number' => $r['mbMobileNo'] ?? '',
    'body'          => $r['fbContent'] ?? '',
    'website_name'  => $r['fbWebsiteName'] ?? '',
    'category_name' => $r['fbCategory'] ?? '',
    'status'        => $r['fbStatus'] ?? '',
    'created_at'    => $r['fbCreatedAt'] ?? '', 
     'source'        => 'ISC'
  ];
}, $complaints1 ?? []);

// 🔹 Remap CampusWear API fields
$mapped2 = array_map(function ($r) {
  return [
    'feedback_id'   => $r['feedback_id'] ?? '',
    'user_id'       => $r['user_id'] ?? '0',
    'name'          => $r['name'] ?? '',
    'email'         => $r['email'] ?? '',
    'mobile_number' => $r['mobile_number'] ?? '',
    'body'          => $r['body'] ?? '',
    'website_name'  => $r['website_name'] ?? 'CampusWear',
    'category_name' => $r['category_name'] ?? '',
    'status'        => $r['status'] ?? '',
    'created_at'    => $r['created_at'] ?? '',
    'source'        => 'CampusWear'
  ];
}, $complaints2 ?? []);

// 🔹 Merge both sources
$complaints = array_merge($mapped1, $mapped2);

if (empty($complaints) && file_exists($file)) {
  $reports = json_decode(file_get_contents($file), true);
  $newData = false; // no fresh API data
} else {
  $reports = $complaints;
  $newData = !empty($complaints);
}

// 🔹 Filter only "open" reports
$openReports = array_filter($reports, function ($r) {
  return isset($r['status']) && strtolower($r['status']) === 'open';
});
?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CAMS - Incoming</title>
  <link rel="stylesheet" href="includes/design.css">
  <link rel="icon" type="image/png" href="icon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>



<?php include 'includes/bgcolor.html'; ?>

<?php include 'includes/navbars.php'; ?>
<main>
  <?php include 'includes/received.php'; ?>
</main>
<?php include 'includes/footer.html'; ?>
<?php include 'includes/modalNotif.html'; ?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const messageBox = document.getElementById("notificationMessage");
    const modal = new bootstrap.Modal(document.getElementById("notificationModal"));


    if (urlParams.get('success') === '1') {
      const msg = "Complaint accepted and saved!";
      messageBox.innerHTML = `<div class='text-success fw-bold'>${msg}</div>`;
      modal.show();

    } else if (urlParams.get('duplicate') === '1') {
      const msg = "This entry was already saved.";
      messageBox.innerHTML = `<div class='text-dark fw-bold'>${msg}</div>`;
      modal.show();
    } else if (urlParams.get('spam') === '1') {
      const msg = "Mark as Spam.";
      messageBox.innerHTML = `<div class='text-dark fw-bold'>${msg}</div>`;
      modal.show();




    }
  });
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>