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
                $znacka = htmlspecialchars($auto["znacka"]);
                $model = htmlspecialchars($auto["model"]);
                $karoserie = htmlspecialchars($auto["karoserie"]);
                $cena = htmlspecialchars($auto["cena"]);
                $rok = htmlspecialchars($auto["rok"]);
                $palivo = htmlspecialchars($auto["palivo"]);
                $prevodovka = htmlspecialchars($auto["prevodovka"]);
                $informace = htmlspecialchars($auto["informace"]);
                $obrazek = !empty($auto["obrazek"]) ? htmlspecialchars($auto["obrazek"]) : null;
                ?>

                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="styly/navbar.css">
                    <title>Detail auta</title>
                </head>
                <body>
                <nav class="navbar">
                    <div class="main__header">
                        <a href="index.php"><img src="logo/bazos_logo.png" alt="" class="logo"></a>
                        <div class="search__header">
                            <form action="">
                                <label for="vyhledavat"></label>
                                <input type="search" id="vyhledavat" name="vyhledavat" placeholder="Zadejte název, příklad: Škoda Fabia benzín kombi klima 2010 ..." autocomplete="off">
                                <input type="submit" class="search__btn" value="Hledat">
                            </form>
                        </div>
                        <ul class="navbar__menu">
                            <li class="navbar__item">
                                <a href="pridaniAuta.php" class="navbar__links">Přidat inzerát</a>
                            </li>
                            <li class="navbar__item">
                                <a href="moje-inzeraty.php" class="navbar__links">Moje inzeráty</a>
                            </li>
                            <li class="navbar__item">
                                <a href="ucet.php" class="navbar__links">Můj účet</a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <h2>Značka: <?php echo $znacka; ?></h2>
                <p>Model: <?php echo $model; ?></p>
                <p>Karoserie: <?php echo $karoserie; ?></p>
                <p>Cena: <?php echo $cena; ?></p>
                <p>Rok výroby: <?php echo $rok; ?></p>
                <p>Palivo: <?php echo $palivo; ?></p>
                <p>Převodovka: <?php echo $prevodovka; ?></p>
                <p>Informace: <?php echo $informace; ?></p>

                <?php if (!empty($obrazek)) { ?>
                    <img src="<?php echo $obrazek; ?>" alt="Obrázek vozidla">
                <?php } ?>

                <a href="index.php">Hlavní Stránka</a>
                </body>
                </html>

                <?php
            }
        } else {
            echo mysqli_stmt_error($stmt);
        }
    }
} else {
    echo "Neplatné ID auta.";
}
?>
