<?php
require("assets/DBConnect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = connDB();
$user_id = $_SESSION['user_id'];

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
                        <a href="editace-inzeratu.php?id=<?= $one_auto['id'] ?>">Upravit</a>
                        <a href="deleteAuto.php?id=<?= $one_auto['id'] ?>">Odstranit</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="index.php">Zpět na hlavní stránku</a>
    </section>
</main>
</body>
</html>
