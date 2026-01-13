<?php
// Always return JSON so clients know what to expect
header('Content-Type: application/json');

// Read raw input if Content-Type is JSON
$input = file_get_contents("php://input");
$data  = json_decode($input, true);

// Fallback to $_POST if not JSON
if (!$data) {
    $data = $_POST;
}

// Extract fields safely
$from     = $data['from']        ?? '';
$text     = $data['text']        ?? '';
$sent     = $data['sentStamp']   ?? '';
$received = $data['receivedStamp'] ?? '';
$sim      = $data['sim']         ?? '';
$from = preg_replace('/\D/', '', $from); // keep digits only
if (substr($from, 0, 2) === '63') {
    $from = '0' . substr($from, 2);
}


if ($from && $text) {
    $file = __DIR__ . '/replies.json'; // safer: absolute path

    // Load existing data safely
    $existing = [];
    if (file_exists($file)) {
        $decoded = json_decode(file_get_contents($file), true);
        if (is_array($decoded)) {
            $existing = $decoded;
        }
    }

    // Append new entry
    $existing[] = [
        'sender'      => $from,
        'message'     => $text,
        'sent_at'     => $sent,
        'received_at' => $received,
        'sim_slot'    => $sim
    ];

    // Save back to file
    if (file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT))) {
        echo json_encode(["status" => "success", "message" => "Reply saved"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Failed to write file"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Missing parameters"]);
}
