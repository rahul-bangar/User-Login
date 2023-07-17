<?php
require_once('config.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id' LIMIT 1";
$result = mysqli_query($db, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome, <?php echo $user['name']; ?>!</title>
    <link rel="stylesheet" type="text/css" href="st.css">
</head>
<body>
    <h1>Welcome, <?php echo $user['name']; ?>!</h1>
    <p>Here are your details:</p>
    <ul>
        <li>Name: <?php echo $user['name']; ?></li>
        <li>Age: <?php echo $user['age']; ?></li>
        <li>Gender: <?php echo $user['gender']; ?></li>
        <li>Email: <?php echo $user['email']; ?></li>
    </ul>
    <form action="logout.php">
        <input type="submit" value="Logout">
    </form>
</body>
</html>
