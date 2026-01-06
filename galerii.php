<?php
require ('config0.php');
global $connect;

if(isset($_REQUEST['lisa1punkt'])){
    $paring=$connect->prepare("update valimused set punktid=punktid+1 where id=?");
    $paring->bind_param("i",$_REQUEST['lisa1punkt']);
    $paring->execute();
    header("location:".$_SERVER['PHP_SELF']); //aadressiriba puhastab paring ja jaab failinimi
}
//kommetaari lisamine - update
if(isset($_REQUEST['uue_komment_id'])){
    $paring=$connect->prepare("update valimused set kommentaarid=CONCAT(kommentaarid, ?) where id=?");
    $komment2=$_REQUEST['uus_kommentaar']."\n";
    $paring->bind_param("si", $komment2, $_REQUEST['uue_komment_id']);
    $paring->execute();
    header("location:".$_SERVER['PHP_SELF']); //aadressiriba puhastab paring ja jaab failinimi
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Valimiste leht</title>
</head>
<body>
<h1>Valimiste galerii</h1>
<nav>
    <ul>
        <li>
            <a href="valimised.php">Kasutaja leht</a>
        </li>
        <li>
            <a href="valimisedAdmin.php">Admin</a>
        </li>
        <li>
            <a href="galerii.php">Galerii</a>
        </li>
    </ul>
</nav>

<div id="menyykiht">
    <?php
    $paring = $connect->prepare("SELECT id, pilt FROM valimused");
    $paring->bind_result($id, $pilt);
    $paring->execute();

    while($paring->fetch()){
        echo "<li>
            <a href='galerii.php?id=$id'>
                <img src='".htmlspecialchars($pilt)."' alt='pilt'>
            </a>
          </li>";
    }

    ?>
</div>

<div id="sisukiht">
    <?php
    if(isSet($_REQUEST["id"])){
        $paring = $connect->prepare("SELECT id, president, punktid, lisamisaeg, kommentaarid FROM valimused WHERE id=?");
        $paring->bind_param("i", $_REQUEST["id"]);
        $paring->bind_result($id, $president, $punktid, $lisamisaeg, $kommentaarid);
        $paring->execute();

        if($paring->fetch()){
            echo "<h2>".htmlspecialchars($president)."</h2>
            <a href='?lisa1punkt=$id'>Lisa 1 punkt</a>
            <p>Punktid: ".htmlspecialchars($punktid)."</p>
            <p>Lisatud: ".htmlspecialchars($lisamisaeg)."</p>
            <div>Kommentaarid: <br>".nl2br(htmlspecialchars($kommentaarid))."</div>
            <br>
            <form action='' method='POST'>
            <input type='hidden' name='uue_komment_id' value='$id'>
            <label for='uus_kommentaar'>Lisa kommentaar:</label>
            <input type='text' name='uus_kommentaar' id='uus_kommentaar'>
            <input type='submit' value='OK'>
            </form>
";

        } else {
            echo "Vigased andmed.";
        }
    }
    ?>
</div>

</body>
</html>
<?php
$connect->close();
?>