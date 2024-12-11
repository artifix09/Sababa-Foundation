<?php
// Initialize an empty array to store errors
$errors = [];

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // Validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email address is required.";
    }
    if (empty($subject)) {
        $errors[] = "Subject is required.";
    }
    if (empty($message)) {
        $errors[] = "Message cannot be empty.";
    }

    // Check for errors
    if (count($errors) > 0) {
        // If there are errors, display them to the user
        echo "<h3>The following errors occurred:</h3>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        echo "<p><a href='javascript:history.back()'>Go Back and Fix the Errors</a></p>";
        exit;
    }

    // Save data to a file
    $file_path = __DIR__ . "/form_submissions.txt";
    $entry = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message\n---\n";

    try {
        $file = fopen($file_path, "a");
        if (!$file) {
            throw new Exception("Unable to open the file for saving data.");
        }
        if (fwrite($file, $entry) === false) {
            throw new Exception("Unable to write to the file.");
        }
        fclose($file);
    } catch (Exception $e) {
        echo "<h3>An error occurred while saving your data:</h3>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><a href='javascript:history.back()'>Go Back and Try Again</a></p>";
        exit;
    }

    // Optional: Send a confirmation email
    $to = $email;
    $email_subject = "Confirmation: $subject";
    $email_body = "Hello $name,\n\nThank you for contacting us. Here is a copy of your message:\n\n$message\n\nBest regards,\nYour Website Team";
    $headers = "From: no-reply@yourdomain.com";

    // Uncomment this to enable email sending (make sure your server supports mail function or set up SMTP)
    /*
    if (!mail($to, $email_subject, $email_body, $headers)) {
        echo "<h3>An error occurred while sending the confirmation email.</h3>";
        echo "<p><a href='javascript:history.back()'>Go Back</a></p>";
        exit;
    }
    */

    // Redirect to the thank-you page
    header("Location: thank_you_page.html");
    exit;
} else {
    // If the form is not submitted via POST, deny access
    echo "<h3>Invalid request method.</h3>";
    echo "<p><a href='index.html'>Go Back to the Contact Form</a></p>";
    exit;
}
?>
