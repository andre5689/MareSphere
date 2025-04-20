
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        header('Location: Contact.html?status=empty');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: Contact.html?status=invalidemail');
        exit();
    }

    // Email configuration
    $to = "burchard@maresphere.com";
    $subject = "Contact Form Submission from $name";
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "Content-Type: text/plain; charset=UTF-8";
    
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message";

    // Send email
    if (mail($to, $subject, $email_content, $headers)) {
        header('Location: Contact.html?status=success');
    } else {
        header('Location: Contact.html?status=error');
    }
} else {
    header('Location: Contact.php');
}
?>
