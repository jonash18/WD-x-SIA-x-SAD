<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $report = [
        "name" => $_POST['name'],
        "email" => $_POST['email'],
        "mobile_number" => $_POST['mobile_number'],
        "body" => $_POST['body'],
        "website_name" => $_POST['website_name'],
        "category_name" => $_POST['category_name'],
        "status" => "open"
    ];

    $file = 'reports.json';

    // Load existing reports
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
    } else {
        $data = [];
    }

    // Add new report
    $data[] = $report;

    // Save back to file
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

    echo "Report submitted successfully!";
}
?>