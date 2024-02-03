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
    <link rel="stylesheet" href="styly/default.css">
    <link rel="stylesheet" href="styly/login.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuh0NPvS15KYnjxØBTØQEEqLprO+NBkkk5gbc67FTaL7XIGa2w1LØXbgc" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
<main class="main__container darkmode-toggle">
    <section class="login__container">
        <div class="form-header__container">
            <h2 class="nadpis">Přihlášení</h2>
            <i class="fas fa-moon darkmode-icon" id="toggle-darkmode"></i>
            <i class="fas fa-sun lightmode-icon" id="toggle-lightmode"></i>
        </div>

        <form action="login.php" method="post">
            <div class="email__container">
                <label for="email">Email</label>
                <input type="email"
                       id="email"
                       placeholder="Email"
                       name="username"
                       autocomplete="off"
                       required>
            </div>
            <div class="password__container">
                <label for="password">Heslo</label>
                <input type="password"
                       id="password"
                       placeholder="Heslo"
                       name="password"
                       autocomplete="off"
                       required>
            </div>
            <div class="login-btn__container">
                <input type="submit" class="login__btn" value="Přihlásit se">
            </div>
        </form>
        <div class="reg__container">
            <p>Ještě nejsi zaregistrovaný? Zaregistruj se <a href="register.php">zde.</a></p>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const darkModeToggle = document.getElementById("toggle-darkmode");
        const lightModeToggle = document.getElementById("toggle-lightmode");
        const body = document.querySelector(".darkmode-toggle");

        const isDarkMode = localStorage.getItem('darkMode') === 'true';

        if (isDarkMode) {
            body.classList.add("darkmode");
            darkModeToggle.style.display = 'none';
            lightModeToggle.style.display = 'inline-block';
        }

        darkModeToggle.addEventListener('click', () => {
            body.classList.remove("lightmode");
            body.classList.add("darkmode");

            localStorage.setItem('darkMode', 'true');

            darkModeToggle.style.display = 'none';
            lightModeToggle.style.display = 'inline-block';
        });

        lightModeToggle.addEventListener('click', () => {
            body.classList.remove("darkmode");
            body.classList.add("lightmode");

            localStorage.setItem('darkMode', 'false');

            lightModeToggle.style.display = 'none';
            darkModeToggle.style.display = 'inline-block';
        });
    });
</script>
</body>
</html>