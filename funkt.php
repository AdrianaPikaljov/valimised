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