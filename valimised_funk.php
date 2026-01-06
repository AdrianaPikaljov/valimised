<?php
require('funkt.php');

if (isset($_REQUEST['lisa1punktid'])) {
    lisa1punktid($_REQUEST['lisa1punktid']);
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}