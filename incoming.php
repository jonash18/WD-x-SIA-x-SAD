<?php

$tabName = "Incoming";

$jsonUrl  = "http://localhost/WEBDEV/testAPI/api_reports.php";
$jsonData = file_get_contents($jsonUrl);
$complaints = json_decode($jsonData, true);

$file = 'reports.json';
$reports = [];

if (empty($complaints) && file_exists($file)) {
  $reports = json_decode(file_get_contents($file), true);
  $newData = false; // no fresh API data
} else {
  $reports = $complaints;
  $newData = !empty($complaints); // true if API returned something
}

$openReports = array_filter($reports, function ($r) {
  return strtolower($r['status']) === 'open';
});
?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Incoming</title>
  <link rel="stylesheet" href="includes/design.css">
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
      modal.show();}

      else if (urlParams.get('spam') === '1') {
      const msg = "Mark as Spam.";
      messageBox.innerHTML = `<div class='text-dark fw-bold'>${msg}</div>`;
      modal.show();




    }
  });
  
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>