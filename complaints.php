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
WHERE c.category_name = 'Complaint'
ORDER BY d.created_at DESC;
";
$result = executeQuery($getQuery);
$tabName = "Complaints";
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complaints</title>
    <link rel="stylesheet" href="includes/design.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>



<?php include 'includes/bgcolor.html'; ?>

<?php include 'includes/navbars.php'; ?>
<main>
    <?php include 'includes/content.php'; ?>
</main>
<?php include 'includes/footer.html'; ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>