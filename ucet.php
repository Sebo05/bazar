<?php
session_start();

if (!isset($_SESSION['first_name'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

require("assets/DBConnect.php");
$conn = connDB();

$email = $_SESSION['first_name'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $user_name = $row['first_name'] . " " . $row['second_name'];
} else {
    $user_name = "Neznámý uživatel";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Účet</title>
</head>
<body>
<header>
    <h1>Vítejte, <?php echo $user_name; ?>!</h1>
    <div class="odkazy">
        <a href="pridaniAuta.php">Přidání automobilu</a>
        <a href="index.php">Hlavni stránka</a>
        <a href="moje-inzeraty.php">Moje inzeraty</a>
    </div>
    <form method="post">
        <button type="submit" name="logout">Odhlásit se</button>
    </form>
</header>
</body>
</html>
