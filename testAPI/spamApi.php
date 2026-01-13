<?php

header('Content-Type: application/json');
$file = 'reports.json';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Read-only: return the reports.json content
    if (file_exists($file)) {
        echo file_get_contents($file);
    } else {
        echo json_encode([]);
    }
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the status of a report to 'received' based on name, email, and body
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['name'], $input['email'], $input['body'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields (name, email, body)']);
        exit;
    }
    if (!file_exists($file)) {
        http_response_code(404);
        echo json_encode(['error' => 'reports.json not found']);
        exit;
    }
    $reports = json_decode(file_get_contents($file), true);
    $found = false;
    foreach ($reports as &$report) {
        if (
            isset($report['name'], $report['email'], $report['body']) &&
            $report['name'] === $input['name'] &&
            $report['email'] === $input['email'] &&
            $report['body'] === $input['body']
        ) {
            $report['status'] = 'spam';
            $found = true;
        }
    }
    if ($found) {
        file_put_contents($file, json_encode($reports, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Report not found']);
    }
    exit;
}

// If not GET or POST
http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
?>
