<?php

header('Content-Type: application/json');


$input = file_get_contents("php://input");
$data  = json_decode($input, true);


if (!$data) {
    $data = $_POST;
}


$from     = $data['from']        ?? '';
$text     = $data['text']        ?? '';
$sent     = $data['sentStamp']   ?? '';
$received = $data['receivedStamp'] ?? '';
$sim      = $data['sim']         ?? '';
$from = preg_replace('/\D/', '', $from); 
if (substr($from, 0, 2) === '63') {
    $from = '0' . substr($from, 2);
}


if ($from && $text) {
    $file = __DIR__ . '/replies.json'; 

    
    $existing = [];
    if (file_exists($file)) {
        $decoded = json_decode(file_get_contents($file), true);
        if (is_array($decoded)) {
            $existing = $decoded;
        }
    }

    
    $existing[] = [
        'sender'      => $from,
        'message'     => $text,
        'sent_at'     => $sent,
        'received_at' => $received,
        'sim_slot'    => $sim
    ];

    
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
