<?php
require("assets/DBConnect.php");

$conn = connDB();

if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST["id"])) {
    $id = $_POST["id"];
    $znacka = $_POST["znacka"];
    $model = $_POST["model"];
    $karoserie = $_POST["karoserie"];
    $cena = $_POST["cena"];
    $rok = $_POST["rok"];
    $palivo = $_POST["palivo"];
    $prevodovka = $_POST["prevodovka"];
    $informace = $_POST["informace"];

    $sql = "UPDATE auta SET znacka=?, model=?, karoserie=?, cena=?, rok=?, palivo=?, prevodovka=?, informace=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "sssiisssi", $znacka, $model, $karoserie, $cena, $rok, $palivo, $prevodovka, $informace, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: moje-inzeraty.php");
            exit;
        } else {
            echo mysqli_stmt_error($stmt);
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] === 'GET' && isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT * FROM auta WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $auto = mysqli_fetch_assoc($result);

            if ($auto === null) {
                echo "Auto s tímto ID nebylo nalezeno.";
            } else {
                // Zde můžete zobrazit formulář pro úpravu inzerátu
                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Upravit inzerát</title>
                </head>
                <body>
                <h2>Upravit inzerát</h2>
                <form action="editace-inzeratu.php" method="post">
                    <input type="hidden" name="id" value="<?= $auto['id'] ?>">
                    <label for="znacka">Značka:</label>
                    <input type="text" name="znacka" id="znacka" value="<?= htmlspecialchars($auto["znacka"]) ?>"><br>
                    <label for="model">Model:</label>
                    <input type="text" name="model" id="model" value="<?= htmlspecialchars($auto["model"]) ?>"><br>
                    <label for="karoserie">Karoserie:</label>
                    <input type="text" name="karoserie" id="karoserie" value="<?= htmlspecialchars($auto["karoserie"]) ?>"><br>
                    <label for="cena">Cena:</label>
                    <input type="number" name="cena" id="cena" value="<?= htmlspecialchars($auto["cena"]) ?>"><br>
                    <label for="rok">Rok výroby:</label>
                    <input type="number" name="rok" id="rok" value="<?= htmlspecialchars($auto["rok"]) ?>"><br>
                    <label for="palivo">Palivo:</label>
                    <input type="text" name="palivo" id="palivo" value="<?= htmlspecialchars($auto["palivo"]) ?>"><br>
                    <label for="prevodovka">Převodovka:</label>
                    <input type="text" name="prevodovka" id="prevodovka" value="<?= htmlspecialchars($auto["prevodovka"]) ?>"><br>
                    <label for="informace">Informace:</label>
                    <input type="text" name="informace" id="informace" value="<?= htmlspecialchars($auto["informace"]) ?>"><br>
                    <input type="submit" value="Uložit změny">
                </form>
                </body>
                </html>
                <?php
            }
        } else {
            echo mysqli_stmt_error($stmt);
        }
    }
} else {
    echo "Neplatný požadavek.";
}
?>
