<?php
require_once('config.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, age, gender, email, password) VALUES ('$name', '$age', '$gender', '$email', '$password_hash')";

    if (mysqli_query($db, $sql)) {
        $_SESSION['message'] = "Registration successful. Please login.";
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Registration failed: " . mysqli_error($db);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="st.css">
</head>
<body>
    <h1>User Registration</h1>
    <?php
    if (isset($error_message)) {
        echo "<p class='error'>$error_message</p>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br>
        
        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>
