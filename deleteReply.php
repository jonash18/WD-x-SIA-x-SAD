<?php
$file = __DIR__ . '/includes/replies.json';

if (file_exists($file)) {
    $replies = json_decode(file_get_contents($file), true);

    if (is_array($replies)) {
        $index = intval($_POST['index'] ?? -1);

        if ($index >= 0 && $index < count($replies)) {
            // Remove the entry
            array_splice($replies, $index, 1);

            // Save back to file
            file_put_contents($file, json_encode($replies, JSON_PRETTY_PRINT));

            echo "Reply deleted successfully.";
        } else {
            echo "Invalid index.";
        }
    } else {
        echo "Invalid JSON format.";
    }
} else {
    echo "No replies.json file found.";
}
?>