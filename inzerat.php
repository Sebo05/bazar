<?php
require("assets/DBConnect.php");

$conn = connDB();

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
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
                // Zde můžete zobrazit informace o autě
                echo "<h2>Značka: " . htmlspecialchars($auto["znacka"]) . "</h2>";
                echo "<p>Model: " . htmlspecialchars($auto["model"]) . "</p>";
                echo "<p>Karoserie: " . htmlspecialchars($auto["karoserie"]) . "</p>";
                echo "<p>Cena: " . htmlspecialchars($auto["cena"]) . "</p>";
                echo "<p>Rok výroby: " . htmlspecialchars($auto["rok"]) . "</p>";
                echo "<p>Palivo: " . htmlspecialchars($auto["palivo"]) . "</p>";
                echo "<p>Převodovka: " . htmlspecialchars($auto["prevodovka"]) . "</p>";
                echo "<p>Informace: " . htmlspecialchars($auto["informace"]) . "</p>";
                if (!empty($auto["obrazek"])) {
                    echo "<img src='" . htmlspecialchars($auto["obrazek"]) . "' alt='Obrázek vozidla'>";
                }
                echo "<a href='index.php'>Hlavní Stránka</a>";
            }
        } else {
            echo mysqli_stmt_error($stmt);
        }
    }
} else {
    echo "Neplatné ID auta.";
}

