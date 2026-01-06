<?php
require ('config0.php');
//+1punkt
global $connect;
if(isset($_REQUEST['lisa1punkt'])){
$paring=$connect->prepare("update valimused set punktid=punktid+1 where id=?");
$paring->bind_param("i",$_REQUEST['lisa1punkt']);
$paring->execute();
header("location:".$_SERVER['PHP_SELF']); //aadressiriba puhastab paring ja jaab failinimi
    $connect->close();
}
//-1punkt
global $connect;
if(isset($_REQUEST['eemalda1punkt'])){
    $paring=$connect->prepare("update valimused set punktid=punktid-1 where id=?");
    $paring->bind_param("i",$_REQUEST['eemalda1punkt']);
    $paring->execute();
    header("location:".$_SERVER['PHP_SELF']);
    $connect->close();
}
//lisamine andmetabelisse
if(ISSET($_REQUEST['presidentNimi'])&& !empty($_REQUEST['presidentNimi'])){
$paring=$connect->prepare("insert into valimused(president, pilt, lisamisaeg, avalik) values(?,?,NOW(), ?)");
$paring->bind_param('ssi',$_REQUEST['presidentNimi'],$_REQUEST['pilt'], $_REQUEST['avalik']);
$paring->execute();
header("location:".$_SERVER['PHP_SELF']);
    $connect->close();
}
if(isset($_REQUEST['naita_id'])){
    $paring=$connect->prepare("update valimused set avalik=1 where id=?");
    $paring->bind_param("i",$_REQUEST['naita_id']);
    $paring->execute();
    header("location:".$_SERVER['PHP_SELF']);
    $connect->close();
}

if(isset($_REQUEST['peida_id'])){
    $paring=$connect->prepare("update valimused set avalik=0 where id=?");
    $paring->bind_param("i",$_REQUEST['peida_id']);
    $paring->execute();
    header("location:".$_SERVER['PHP_SELF']);
    $connect->close();
}

if(isSet($_REQUEST["kustuta"])){
    $paring = $connect->prepare("DELETE FROM valimused WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustuta"]);
    header("location:".$_SERVER['PHP_SELF']);
    $paring->execute();
}

global $connect;
if(isset($_REQUEST['eemaldapunktid'])){
    $paring=$connect->prepare("update valimused set punktid=0 where id=?");
    $paring->bind_param("i",$_REQUEST['eemaldapunktid']);
    $paring->execute();
    header("location:".$_SERVER['PHP_SELF']);
    $connect->close();
}

if(isset($_REQUEST['eemaldakomment'])){
    $paring=$connect->prepare("update valimused set kommentaarid='' where id=?");
    $paring->bind_param("i",$_REQUEST['eemaldakomment']);
    $paring->execute();
    header("location:".$_SERVER['PHP_SELF']);
    $connect->close();
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
        <th>Haldus</th>
        <th>Staatus</th>
        <th>Eemalda presidenti</th>
        <th>Punktid nulliks</th>
        <th>Kommentaarid</th>
        <th>Eemalda kommentaarid</th>
    </tr>

    <?php
    global $connect;
    $paring=$connect->prepare("SELECT id, president, pilt, punktid, lisamisaeg, avalik, kommentaarid FROM valimused");
    $paring->bind_result($id, $president, $pilt, $punktid, $lisamisaeg, $avalik, $kommentaarid);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>".$president."</td>";
        echo "<td><img src='$pilt' alt='pilt'></td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$lisamisaeg."</td>";
        $tekst="Näita";
        $seisund="naita_id";
        $tekstLehel="Peidetud";
        if($avalik==1){
            $tekstLehel="Näidatud";
            $seisund='peida_id';
            $tekst='Peida';
        }
        echo"<td><a href='?$seisund=$id'>$tekst</td>";
        echo "<td>$tekstLehel</td>";

        echo "<td><a href='?kustuta=$id'>Eemalda</a></td>";
        echo "<td><a href='?eemaldapunktid=$id'>Kustuta punktid</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td><a href='?eemaldakomment=$id'>Kustuta kommentaarid</a></td>";
        echo "</tr>";

    }
    /*Admin:
    1.delete kandidaadi
    2.punktid nulliks
    3.ei saa +/-1 punkt
    4.admin kohe saab lisada avalikuse staatus

    */
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
    <label for="avalik">Staatus:</label>
    <select name="avalik" id="avalik" required>
        <option value="">Vali staatus</option>
        <option value="1">Avalik</option>
        <option value="0">Peidetud</option>
    </select>
    <br>
    <input type="submit" value="Lisa">
</form>

</body>
</html>
