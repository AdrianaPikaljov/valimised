<?php
require ('config0.php');
function lisa1punktid($id)
{
    global $connect;
    $paring = $connect->prepare(
        "UPDATE valimused SET punktid = punktid + 1 WHERE id=?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
    $paring->close();
}

function kustuta1punktid($id)
{
    global $connect;
    $paring = $connect->prepare(
        "UPDATE valimused SET punktid = punktid - 1 WHERE id=?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
    $paring->close();
}

function naitatabel()
{
    global $connect;

    $paring = $connect->prepare("
        SELECT id, president, pilt, punktid, lisamisaeg, kommentaarid, avalik
        FROM valimused
    ");
    $paring->execute();
    $paring->bind_result($id, $president, $pilt, $punktid, $lisamisaeg, $kommentaarid, $avalik);

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>$president</td>";
        echo "<td>$punktid</td>";
        echo "<td><img src='$pilt' alt='pilt'></td>";
        echo "<td><a href='?lisa1punktid=$id'>+1</a></td>";
        echo "<td><a href='?kustuta1punktid=$id'>-1</a></td>";
        echo "<td><a href='?kusututaPresident=$id'>Kustuta</a></td>";
        echo "<td>" . nl2br(htmlspecialchars($kommentaarid)) . "</td>";
        echo "<td>
            <form action='' method='post'>
                <input type='hidden' name='uue_komment_id' value='$id'>
                <input type='text' name='uus_kommentaar'>
                <input type='submit' value='OK'>
            </form>        </td>";
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


        echo "</tr>";
    }

    $paring->close();
}

function lisaPresident($presidentNimi, $pilt)
{
    global $connect;
    $paring = $connect->prepare(
        "INSERT INTO valimused (president, pilt, punktid, lisamisaeg)
         VALUES (?, ?, 0, NOW())"
    );
    $paring->bind_param("ss", $presidentNimi, $pilt);
    $paring->execute();
    $paring->close();
}

function kusututaPresident($id)
{
    global $connect;
    $paring = $connect->prepare(
        "DELETE FROM valimused WHERE id=?"
    );
    $paring->bind_param("i", $id);
    $paring->execute();
    $paring->close();
}

function uuskommentaar($komment2, $id)
{
    global $connect;
    $paring = $connect->prepare("update valimused set kommentaarid=CONCAT(kommentaarid, ?) where id=?");
    $paring->bind_param("si", $komment2, $id);
    $paring->execute();
    $paring->close();
}


function naitaPresident($id)
{
    global $connect;
    $paring = $connect->prepare(
        "UPDATE valimused SET avalik=1 WHERE id=?"
    );
    $paring->bind_param("i", $id);
    $paring->execute();
    $paring->close();
}

function peidaPresident($id)
{
    global $connect;
    $paring = $connect->prepare(
        "UPDATE valimused SET avalik=0 WHERE id=?"
    );
    $paring->bind_param("i", $id);
    $paring->execute();
    $paring->close();
}
