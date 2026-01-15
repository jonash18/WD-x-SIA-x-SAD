<?php
$file = __DIR__ . '/includes/replies.json';

if (file_exists($file)) {
    $replies = json_decode(file_get_contents($file), true);

    if (is_array($replies)) {
        $message = trim($_POST['message'] ?? '');
        if ($message !== '') {
            $found = false;
            foreach ($replies as $key => $reply) {
                if (isset($reply['message']) && $reply['message'] === $message) {
                    unset($replies[$key]);
                    $replies = array_values($replies);
                    file_put_contents($file, json_encode($replies, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    echo "Reply deleted successfully.";
                    $found = true;
                    break;
                }
            }
            if (!$found) echo "Reply not found.";
        } else {
            echo "No message provided.";
        }
    } else {
        echo "Invalid JSON format.";
    }
} else {
    echo "No replies.json file found.";
}
?>