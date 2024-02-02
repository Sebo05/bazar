<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require("./assets/DBConnect.php");

$znacka = $model = $karoserie = $cena = $rok = $palivo = $prevodovka = $informace = $picture = null;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $znacka = $_POST["znacka"];
    $model = $_POST["model"];
    $karoserie = $_POST["karoserie"];
    $cena = $_POST["cena"];
    $rok = $_POST["rok"];
    $palivo = $_POST["palivo"];
    $prevodovka = $_POST["prevodovka"];
    $informace = $_POST["informace"];

    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $pictureTmpName = $_FILES['picture']['tmp_name'];
        $pictureName = $_FILES['picture']['name'];
        $pictureDestination = "./uploads/" . $pictureName;
        move_uploaded_file($pictureTmpName, $pictureDestination);
    }

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO auta(znacka, model, karoserie, cena, rok, palivo, prevodovka, informace, user_id, obrazek)
                VALUES(?,?,?,?,?,?,?,?,?,?)";

        $conn = connDB();
        $statement = mysqli_prepare($conn, $sql);

        if ($statement === false){
            echo mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($statement, "sssiisssis", $znacka, $model, $karoserie, $cena, $rok, $palivo, $prevodovka, $informace, $user_id, $pictureDestination);

            if (mysqli_stmt_execute($statement)){
                $id = mysqli_insert_id($conn);
                header("location: inzerat.php?id=$id");
            } else {
                echo mysqli_stmt_error($statement);
            }
        }
    } else {
        echo "Uživatel není přihlášen.";
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
<header></header>
<main>
    <section class="pridani">
        <form action="pridaniAuta.php" method="post" enctype="multipart/form-data">
            <h2>Přidej svoje vozidlo</h2>
            <input type="text" name="znacka" placeholder="Značka" value="<?=htmlspecialchars($znacka) ?>" required>
            <input type="text" name="model" placeholder="Model" value="<?=htmlspecialchars($model) ?>" required>
            <input type="text" name="karoserie" placeholder="Karoserie" value="<?=htmlspecialchars($karoserie) ?>" required>
            <input type="number" name="cena" placeholder="Cena" value="<?=htmlspecialchars($cena) ?>" required>
            <input type="number" name="rok" placeholder="Rok výroby" value="<?=htmlspecialchars($rok) ?>" required>
            <input type="text" name="palivo" placeholder="Palivo" value="<?=htmlspecialchars($palivo) ?>" required>
            <input type="text" name="prevodovka" placeholder="Převodovka" value="<?=htmlspecialchars($prevodovka) ?>" required>
            <input type="text" name="informace" placeholder="Informace o vozu" value="<?=htmlspecialchars($informace) ?>" required>
            <input type="file" name="picture" accept="image/*">
            <input type="submit" value="Přidat vozidlo">
        </form>
    </section>
</main>
<footer></footer>
</body>
</html>
