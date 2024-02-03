<?php
require("assets/DBConnect.php");

if ($_SERVER["REQUEST_METHOD"] === 'GET' && isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $taskId = $_GET["id"];

    $conn = connDB();
    $selectSql = "SELECT obrazek FROM auta WHERE id = ?";
    $stmt = mysqli_prepare($conn, $selectSql);
    mysqli_stmt_bind_param($stmt, "i", $taskId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $imagePath);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $deleteSql = "DELETE FROM auta WHERE id = ?";
    $stmt = mysqli_prepare($conn, $deleteSql);
    mysqli_stmt_bind_param($stmt, "i", $taskId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    if ($imagePath) {
        unlink($imagePath);
    }

    header("Location: moje-inzeraty.php");
    exit();
}

http_response_code(400);
echo "Chyba: Neplatný požadavek";
?>
