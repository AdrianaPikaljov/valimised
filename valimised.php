<?php
require ('config0.php');
//+1punkt
global $connect;
if(isset($_REQUEST['lisa1punkt'])){
$paring=$connect->prepare("update valimused set punktid=punktid+1 where id=?");
$paring->bind_param("i",$_REQUEST['lisa1punkt']);
$paring->execute();
header("location:".$_SERVER['PHP_SELF']); //aadressiriba puhastab paring ja jaab failinimi
}
//-1punkt
global $connect;
if(isset($_REQUEST['eemalda1punkt'])){
    $paring=$connect->prepare("update valimused set punktid=punktid-1 where id=?");
    $paring->bind_param("i",$_REQUEST['eemalda1punkt']);
    $paring->execute();
    header("location:".$_SERVER['PHP_SELF']);
}
//lisamine andmetabelisse
if(ISSET($_REQUEST['presidentNimi'])&& !empty($_REQUEST['presidentNimi'])){
$paring=$connect->prepare("insert into valimused(president, pilt, lisamisaeg) values(?,?,NOW())");
$paring->bind_param('ss',$_REQUEST['presidentNimi'],$_REQUEST['pilt']);
$paring->execute();
header("location:".$_SERVER['PHP_SELF']);
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
<h1>Valimised</h1>
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
<table>
    <tr>
        <th>Nimi</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Kommentaarid</th>
        <th>Lisa kommentaar</th>
    </tr>

    <?php
    global $connect;
    $paring=$connect->prepare("SELECT id, president, pilt, punktid, lisamisaeg, kommentaarid FROM valimused where avalik=1");
    $paring->bind_result($id, $president, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>".$president."</td>";
        echo "<td><img src='$pilt' alt='pilt'></td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$lisamisaeg."</td>";
        echo "<td><a href='?lisa1punkt=$id'>Lisa 1 punkt</a></td>";
        echo "<td><a href='?eemalda1punkt=$id'>Eemalda 1 punkt</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo"<td>
<form action='?' method='POST'>
<input type='hidden' name='uue_komment_id' value='$id'>
<label for='uus_kommentaar'></label>
<input type='text' name='uus_kommentaar' id='uus_kommentaar'>
<input type='submit' value='ok'>
</form></td>";
        echo "</tr>";
    }

    ?>

</table>
<H2>Lisa oma presidendi</H2>
<form action="">
    <label for="presidentNimi">President nimi:</label>
    <input type="text" name="presidentNimi">
    <br>
    <label for="pilt">Presidendi pilt:</label>
    <textarea name="pilt" id="pilt"></textarea>
    <br>
    <input type="submit" value="Lisa">
</form>

</body>
</html>
