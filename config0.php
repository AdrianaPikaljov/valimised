<?php
$serverinimi='localhost';
$kasutajanimi="adrianapikaljov";
$parool='12345';
$andmebaasinimi='adrianapikaljov';
$connect=new mysqli($serverinimi,$kasutajanimi,$parool,$andmebaasinimi);
$connect->set_charset("utf8");