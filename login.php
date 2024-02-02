<?php
require("assets/DBConnect.php");

$conn = connDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['username'];
    $password = $_POST['password'];

    $first_name = mysqli_real_escape_string($conn, $first_name);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM users WHERE email='$first_name' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['first_name'] = $first_name;
        header("location: ucet.php");
    } else {
        echo "Neplatné jméno nebo heslo.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<main>
    <section>
        <form action="login.php" method="post">
            <label for="email">Email</label>
            <input type="text" id="email" placeholder="Email" name="username" required>
            <label for="password">Heslo</label>
            <input type="password" id="password" placeholder="Heslo" name="password" required>
            <input type="submit" value="Přihlásit se">
        </form>
        <a href="register.php">Zaregistrovat se</a>
    </section>
</main>
</body>
</html>
