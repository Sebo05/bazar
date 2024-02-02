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

                //header("location: kdybychChtelNekamZTohoto.php?id=$id");
            }else{
                echo mysqli_stmt_error($statement);
            }

        }
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
<header>

</header>
<main>
   <section class="register">
       <form action="register.php" method="post">
       <input type="text" id="first_name" placeholder="Jméno" name="first_name" value="<?=htmlspecialchars($first_name)?>" required>
       <input type="text" id="second_name" placeholder="Přijmení" name="second_name" value="<?=htmlspecialchars($second_name)?>" required>
       <input type="text" id="email" placeholder="Email" name="email" value="<?=htmlspecialchars($email)?>" required>
       <input type="password" id="password1" placeholder="Heslo" name="password" value="<?=htmlspecialchars($password)?>" required>
       <input type="password" id="password2" placeholder="" name="password2" value="<?=htmlspecialchars($password2)?>" required>
       <input type="submit" value="Registrovat se">
       </form>
   </section>
</main>
<footer>

</footer>
</body>
</html>
