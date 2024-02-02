<?php
require("assets/DBConnect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = connDB();
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['edit_auto_id'])) {
    $auto_id = $_POST['edit_auto_id'];
    $znacka = $_POST["edit_znacka"];
    $model = $_POST["edit_model"];
    $karoserie = $_POST["edit_karoserie"];
    $cena = $_POST["edit_cena"];
    $rok = $_POST["edit_rok"];
    $palivo = $_POST["edit_palivo"];
    $prevodovka = $_POST["edit_prevodovka"];
    $informace = $_POST["edit_informace"];

    $sql = "UPDATE auta SET znacka=?, model=?, karoserie=?, cena=?, rok=?, palivo=?, prevodovka=?, informace=? WHERE id=? AND user_id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "sssiisssii", $znacka, $model, $karoserie, $cena, $rok, $palivo, $prevodovka, $informace, $auto_id, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: moje-inzeraty.php");
            exit;
        } else {
            echo mysqli_stmt_error($stmt);
        }
    }
}

$sql = "SELECT * FROM auta WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt === false) {
    echo mysqli_error($conn);
} else {
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $auto = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo mysqli_stmt_error($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje inzeráty</title>
</head>
<body>
<header>
    <h1>Moje inzeráty</h1>
</header>
<main>
    <section class="mojeAuta">
        <?php if (empty($auto)): ?>
            <p>Nemáš žádné inzeráty</p>
        <?php else: ?>
            <ul>
                <?php foreach ($auto as $one_auto): ?>
                    <li>
                        <?= htmlspecialchars($one_auto["znacka"] . " " . htmlspecialchars($one_auto["model"])) ?>
                        <?php if (!empty($one_auto["obrazek"])): ?>
                            <img src="<?= htmlspecialchars($one_auto["obrazek"]) ?>" alt="Obrázek inzerátu">
                        <?php endif; ?>
                        <form action="" method="post">
                            <input type="hidden" name="edit_auto_id" value="<?= $one_auto['id'] ?>">
                            <input type="text" name="edit_znacka" value="<?= htmlspecialchars($one_auto["znacka"]) ?>" required>
                            <input type="text" name="edit_model" value="<?= htmlspecialchars($one_auto["model"]) ?>" required>
                            <input type="text" name="edit_karoserie" value="<?= htmlspecialchars($one_auto["karoserie"]) ?>" required>
                            <input type="number" name="edit_cena" value="<?= htmlspecialchars($one_auto["cena"]) ?>" required>
                            <input type="number" name="edit_rok" value="<?= htmlspecialchars($one_auto["rok"]) ?>" required>
                            <input type="text" name="edit_palivo" value="<?= htmlspecialchars($one_auto["palivo"]) ?>" required>
                            <input type="text" name="edit_prevodovka" value="<?= htmlspecialchars($one_auto["prevodovka"]) ?>" required>
                            <input type="text" name="edit_informace" value="<?= htmlspecialchars($one_auto["informace"]) ?>" required>
                            <input type="submit" value="Upravit">
                        </form>
                        <a href="deleteAuto.php?id=<?= $one_auto['id'] ?>">Odstranit</a>
                        <a href="editaceAuta.php?id=<?= $one_auto['id'] ?>">Upravit tento inzerát</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="index.php">Zpět na hlavní stránku</a>
    </section>
</main>
</body>
</html>
