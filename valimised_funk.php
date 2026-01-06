<?php
require('funkt.php');

if (isset($_REQUEST['lisa1punktid'])) {
    lisa1punktid($_REQUEST['lisa1punktid']);
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_REQUEST['kustuta1punktid'])) {
    kustuta1punktid($_REQUEST['kustuta1punktid']);
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_REQUEST['presidentNimi'])) {
    lisaPresident($_REQUEST['presidentNimi'], $_REQUEST['pilt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_REQUEST['kusututaPresident'])) {
    kusututaPresident($_REQUEST['kusututaPresident']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Tabel Valimised Funktsioonidega</title>
</head>
<body>

<h1>Tabel valimised (funktsioonidega)</h1>

<table>
    <tr>
        <th>Nimi</th>
        <th>Punktid</th>
        <th>Pilt</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Kustuta</th>
        <th>Kommentaarid</th>
        <th>Lisa kommentaar</th>
        <th>Staatus</th>
    </tr>

    <?php
    naitatabel();
    ?>

</table>
</body>
</html>