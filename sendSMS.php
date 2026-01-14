<?php
$apiToken = "7a58240b7fe431f76f117d5c1ef5fb031e03cdef"; // your real API token

// ✅ Get values from frontend POST request
$message  = $_POST['message'] ?? '';
$number   = $_POST['phone_number'] ?? '';

$url = "https://www.iprogsms.com/api/v1/sms_messages/send_bulk";

$data = [
    "api_token"    => $apiToken,
    "message"      => $message,
    "phone_number" => $number
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// For testing only (disable SSL verification)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode([
        'success' => false,
        'message' => 'Message Failed'
    ]);
} else {
    echo json_encode([
        'success' => true,
        'message' => 'Message sent!'
    ]);
}
