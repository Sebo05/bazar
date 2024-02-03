<?php
require ("assets/DBConnect.php");

$first_name = null;
$second_name = null;
$email = null;
$password = null;
$password2 = null;

if ($_SERVER["REQUEST_METHOD"] === 'POST'){

    $first_name = $_POST["first_name"];
    $second_name = $_POST["second_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    if ($password != $password2){
        $error = "Hesla se neshodují";
        echo $error;
    }else{
        $sql = "INSERT INTO users(first_name, second_name,email,password)
            VALUES(?,?,?,?)";

        $conn = connDB();
        $statement = mysqli_prepare($conn, $sql);

        if ($statement === false){
            echo mysqli_error($conn);
        }else{
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($statement, "ssss",$_POST["first_name"],$_POST["second_name"],$_POST["email"],$_POST["password"]);

            if (mysqli_stmt_execute($statement)){
                $id = mysqli_insert_id($conn);

                header("location: index.php");
            }else{
                echo mysqli_stmt_error($statement);
            }

        }
    }
}
?>

<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styly/default.css">
    <link rel="stylesheet" href="styly/register.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuh0NPvS15KYnjxØBTØQEEqLprO+NBkkk5gbc67FTaL7XIGa2w1LØXbgc" crossorigin="anonymous">
    <title>Registrace</title>
</head>
<body>
<main class="main__container darkmode-toggle">
    <section class="register__container">
        <div class="form-header__container">
            <h2 class="nadpis">Registrace</h2>
            <i class="fas fa-moon darkmode-icon" id="toggle-darkmode"></i>
            <i class="fas fa-sun lightmode-icon" id="toggle-lightmode"></i>
        </div>
        <form action="register.php" method="post">
            <div class="primary-name__container">
                <input type="text"
                       id="first_name"
                       placeholder="Jméno"
                       name="first_name"
                       value="<?=($first_name)?>"
                       autocomplete="off"
                       required>
                <input type="text"
                       id="second_name"
                       placeholder="Přijmení"
                       name="second_name"
                       value="<?=($second_name)?>"
                       autocomplete="off"
                       required>
            </div>
            <div class="mail__container">
                <input type="email"
                       id="email"
                       placeholder="Email"
                       name="email"
                       value="<?=($email)?>"
                       autocomplete="off"
                       required>
            </div>
            <div class="password__container">
                <input type="password"
                       id="password1"
                       placeholder="Heslo"
                       name="password"
                       value="<?=($password)?>"
                       autocomplete="off"
                       required>
                <input type="password"
                       id="password2"
                       placeholder="Heslo znovu"
                       name="password2"
                       value="<?=($password2)?>"
                       autocomplete="off"
                       required>
            </div>
            <div class="reg-btn__container">
                <input type="submit" class="reg__btn" value="Registrovat se">
            </div>
        </form>
        <div class="login__container">
            <p>Již máš účet? Přihlaš se <a href="login.php">zde.</a></p>
        </div>
    </section>
</main>
<footer>

</footer>

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