<?php
require_once('config.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if user exists with provided email
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Generate reset token and update user's reset token in the database
        $reset_token = bin2hex(random_bytes(32));
        $sql = "UPDATE users SET reset_token='$reset_token' WHERE email='$email'";

        if (mysqli_query($db, $sql)) {
            // Send email with reset link to user
            $reset_link = "http://example.com/reset_password.php?token=$reset_token";
            $to = $email;
            $subject = "Password Reset";
            $message = "Click the link below to reset your password:\n\n$reset_link";
            $headers = "From: webmaster@example.com" . "\r\n" .
                       "Reply-To: webmaster@example.com" . "\r\n" .
                       "X-Mailer: PHP/" . phpversion();

            if (mail($to, $subject, $message, $headers)) {
                $_SESSION['message'] = "Password reset email sent to $email.";
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error sending password reset email.";
            }
        } else {
            $error_message = "Error updating reset token: " . mysqli_error($db);
        }
    } else {
        $error_message = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="st.css">
</head>
<body>
    <h1>Reset Password</h1>
    <?php
    if (isset($error_message)) {
        echo "<p class='error'>$error_message</p>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <input type="submit" value="Send Password Reset Email">
    </form>
    <p>Remembered your password? <a href="login.php">Login here</a>.</p>
</body>
</html>
