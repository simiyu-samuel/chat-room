<?php

define('MESSAGES_FILE', 'messages.txt');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'send') {
        $username = htmlspecialchars(trim($_POST['username'] ?? ''));
        $message = htmlspecialchars(trim($_POST['message'] ?? ''));
        
        if ($username && $message) {
            $formattedMessage = "<p><strong>" . $username . ":</strong> " . $message . "</p>\n";
            file_put_contents(MESSAGES_FILE, $formattedMessage, FILE_APPEND);
        }
    } elseif ($action === 'load') {
        if (file_exists(MESSAGES_FILE)) {
            echo file_get_contents(MESSAGES_FILE);
        } else {
            echo "<p>No messages yet...</p>";
        }
    }
}
