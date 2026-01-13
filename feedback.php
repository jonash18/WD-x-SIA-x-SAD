<?php
include 'connect.php';

$getQuery = "
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
    d.created_at AS date
FROM documents d
LEFT JOIN category c ON d.category_id = c.category_id
LEFT JOIN website w ON d.website_id = w.website_id
WHERE c.category_name = 'Feedback'
ORDER BY d.created_at DESC;
";
$result = executeQuery($getQuery);
$tabName = "Feedback";
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feedback</title>
  <link rel="stylesheet" href="includes/design.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>



<?php include 'includes/bgcolor.html'; ?>

  <?php include 'includes/navbars.php'; ?>
  <main>
    <?php include 'includes/content.php'; ?>
  </main>

  <?php include 'includes/modalNotif.html'; ?>

  <?php include 'includes/footer.html'; ?>

  <script>
    document.querySelectorAll(".donationBtn").forEach(function(button) {
      button.addEventListener("click", function() {
        const name = this.getAttribute("data-name");
        const email = this.getAttribute("data-email");

        fetch("donationMail.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              name: name,
              email: email
            })
          })
          .then(response => response.text())
          .then(data => showModal("Donation email sent successfully!"))
          .catch(error => showModal("Error sending email: " + error));
      });
    });

    function showModal(message) {
      const modalMessage = document.getElementById("modalMessage");
      modalMessage.textContent = message;

      // Bootstrap modal instance
      const donationModal = new bootstrap.Modal(document.getElementById("notificationModal"));
      donationModal.show();
    }
  </script>






  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>