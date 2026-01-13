<?php
$name          = $_POST['name'] ?? '';
$email         = $_POST['email'] ?? '';
$body          = $_POST['body'] ?? '';


// 1. Update JSON file via API endpoint
$apiUrl = 'http://localhost/WEBDEV/testAPI/spamApi.php';
$payload = json_encode([
    'name'  => $name,
    'email' => $email,
    'body'  => $body
]);

$opts = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/json\r\nContent-Length: " . strlen($payload) . "\r\n",
        'content' => $payload
    ]
];
$context = stream_context_create($opts);
@file_get_contents($apiUrl, false, $context);

// 2. Redirect back
header("Location: incoming.php?spam=1");
exit;
?>