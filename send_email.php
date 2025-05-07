<?php
header('Content-Type: application/json');

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
}

$host = $data['host'] ?? '';
$port = $data['port'] ?? 0;
$encryption = $data['encryption'] ?? '';
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';
$from = $data['from'] ?? '';
$to = $data['to'] ?? '';
$subject = $data['subject'] ?? '';
$message = $data['message'] ?? '';

if (!$host || !$port || !$from || !$to || !$subject || !$message) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->Port = (int)$port;

    if ($encryption === 'ssl') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    } elseif ($encryption === 'tls') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    }

    if ($username) {
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
    } else {
        $mail->SMTPAuth = false;
    }

    //Recipients
    $mail->setFrom($from);
    $mail->addAddress($to);

    //Content
    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
}
?>
