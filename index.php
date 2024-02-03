<?php

require("assets/DBConnect.php");

$conn = connDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["vyhledavat"])) {
        $search_term = $_POST["vyhledavat"];

        $sql = "SELECT * FROM auta WHERE znacka LIKE '%$search_term%' OR model LIKE '%$search_term%'";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo mysqli_error($conn);
        } else {
            $auto = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    } else {
        $sql = "SELECT * FROM auta";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo mysqli_error($conn);
        } else {
            $auto = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
} else {
    $sql = "SELECT * FROM auta";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo mysqli_error($conn);
    } else {
        $auto = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="styly/default.css">
    <link rel="stylesheet" href="styly/main.css">
    <link rel="stylesheet" href="styly/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Bazos</title>
</head>
<body>
<nav class="navbar">
    <div class="main__header">
        <a href="index.php"><img src="logo/bazos_logo.png" alt="" class="logo"></a>
        <div class="search__header">
            <form action="index.php" method="POST">
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

<main class="flexmain">
    <div class="menuleft">
        <div class="nadpismenu__container">
            <h1 class="nadpismenu">Osobní auta</h1>
        </div>
        <div class="kat__container">
            <div class="znacky-aut__container">
                <a href="/alfa/" >Alfa Romeo</a>
                <a href="/audi/" >Audi</a>
                <a href="/bmw/" >BMW</a>
                <a href="/citroen/" >Citroën</a>
                <a href="/dacia/" >Dacia</a>
                <a href="/fiat/" >Fiat</a>
                <a href="/ford/" >Ford</a>
                <a href="/honda/" >Honda</a>
                <a href="/hyundai/" >Hyundai</a>
                <a href="/chevrolet/" >Chevrolet</a>
                <a href="/kia/" >Kia</a>
                <a href="/mazda/" >Mazda</a>
                <a href="/mercedes/" >Mercedes-Benz</a>
                <a href="/mitsubishi/" >Mitsubishi</a>
                <a href="/nissan/" >Nissan</a>
                <a href="/opel/" >Opel</a>
                <a href="/peugeot/" >Peugeot</a>
                <a href="/renault/" >Renault</a>
                <a href="/seat/" >Seat</a>
                <a href="/suzuki/" >Suzuki</a>
                <a href="/skoda/" >Škoda</a>
                <a href="/toyota/" >Toyota</a>
                <a href="/volkswagen/" >Volkswagen</a>
                <a href="/volvo/" >Volvo</a>
                <a href="/ostatni/" >Ostatní značky</a>
            </div>
        </div>
    </div>

    <div class="inzeraty__container">
        <div class="inzeraty-header">
            <div class="zobrazeni__container">
                <p>Zobrazení</p>
                <svg id="grid" data-name="Vrstva 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26.99 27.02">
                    <defs>
                        <style>.cls-1{fill:none;}.cls-2{clip-path:url(#clip-path);}.cls-333{fill:#000;}
                        </style>
                        <clipPath id="clip-path" transform="translate(0 0)">
                            <rect class="cls-1" width="26.99" height="27.02"></rect>
                        </clipPath>
                    </defs>
                    <g class="cls-2">
                        <path class="cls-333" d="M11.52,12.36H.84A.85.85,0,0,1,0,11.52V.84A.85.85,0,0,1,.84,0H11.52a.85.85,0,0,1,.84.84V11.52a.85.85,0,0,1-.84.84" transform="translate(0 0)"></path>
                        <path class="cls-333" d="M26.15,12.36H15.47a.85.85,0,0,1-.84-.84V.84A.85.85,0,0,1,15.47,0H26.15A.84.84,0,0,1,27,.84V11.52a.84.84,0,0,1-.84.84" transform="translate(0 0)"></path>
                        <path class="cls-333" d="M11.52,27H.84A.85.85,0,0,1,0,26.18V15.5a.84.84,0,0,1,.84-.84H11.52a.84.84,0,0,1,.84.84V26.18a.85.85,0,0,1-.84.84" transform="translate(0 0)"></path>
                        <path class="cls-333" d="M26.15,27H15.47a.85.85,0,0,1-.84-.84V15.5a.84.84,0,0,1,.84-.84H26.15a.83.83,0,0,1,.84.84V26.18a.84.84,0,0,1-.84.84" transform="translate(0 0)"></path>
                    </g>
                </svg>
                <svg id="list" data-name="Vrstva 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 37 27.04">
                    <defs>
                        <style>.cls-1{fill:none;}.cls-2{clip-path:url(#clip-path);}.cls-444{fill:#000;}
                        </style>
                        <clipPath id="clip-path" transform="translate(0 0)">
                            <rect class="cls-1" width="37" height="27.04"></rect>
                        </clipPath>
                    </defs>
                    <g class="cls-2">
                        <path class="cls-444" d="M11.52,12.36H.84A.85.85,0,0,1,0,11.52V.84A.85.85,0,0,1,.84,0H11.52a.85.85,0,0,1,.84.84V11.52a.85.85,0,0,1-.84.84" transform="translate(0 0)"></path>
                        <path class="cls-444" d="M34.75,8.42H18.05a2.24,2.24,0,1,1,0-4.48h16.7a2.24,2.24,0,1,1,0,4.48" transform="translate(0 0)"></path>
                        <path class="cls-444" d="M11.52,27H.84A.85.85,0,0,1,0,26.2V15.52a.84.84,0,0,1,.84-.84H11.52a.84.84,0,0,1,.84.84V26.2a.85.85,0,0,1-.84.84" transform="translate(0 0)"></path>
                        <path class="cls-444" d="M34.75,23.1H18.05a2.25,2.25,0,1,1,0-4.49h16.7a2.25,2.25,0,1,1,0,4.49" transform="translate(0 0)">
                        </path>
                    </g>
                </svg>
            </div>
        </div>
        <div class="inzeraty-item__container">

            <?php if (empty($auto)): ?>
                <h1>Momentalně nejsou k dispozici žádné inzeráty</h1>
            <?php else: ?>
            <?php foreach ($auto as $one_inzerat): ?>
            <div class="inzerat">
                <a href="inzerat.php?id=<?php echo $one_inzerat['id']?>">
                    <?php if (!empty($one_inzerat["obrazek"])): ?>
                        <div class="inzerat-fotka">
                            <img src="<?= $one_inzerat["obrazek"] ?>" alt="Obrázek inzerátu">
                        </div>
                    <?php endif; ?>
                    <div class="inzerat-info">
                        <h1 class="nazev-inzeratu"><?= htmlspecialchars($one_inzerat["znacka"] . " " . $one_inzerat["model"]) ?></h1>
                        <h2 class="cena-inzeratu">Cena: <?= htmlspecialchars($one_inzerat["cena"]) ?> Kč</h2>
                        <p class="text-inzeratu"><?= htmlspecialchars($one_inzerat["rok"]." ".$one_inzerat["palivo"]." ".$one_inzerat["karoserie"]." ".$one_inzerat["prevodovka"]." ".$one_inzerat["informace"])?></p>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

    </div>
    </div>
</main>
<script>
    const toggleGrid = document.getElementById("grid");
    const toggleList = document.getElementById("list");
    const inzeraty = document.querySelector(".inzeraty-item__container");

    toggleGrid.addEventListener('click', () => {
        inzeraty.classList.remove("inzeraty-item__container-list");
        inzeraty.classList.add("inzeraty-item__container-grid");
    });

    toggleList.addEventListener('click', () => {
        inzeraty.classList.remove("inzeraty-item__container-grid");
        inzeraty.classList.add("inzeraty-item__container-list");
    });

</script>
</body>
</html>
