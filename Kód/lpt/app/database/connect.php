<?php

$host = 'localhost';
$user = 'id17928260_ledofi';
$pass = 'Superheslo.123';
$db_name = 'id17928260_ledofi_db';

/*
$conn = new MySQLi($host, $user, $pass, $db_name);
*/

$conn = mysqli_connect($host, $user, $pass, $db_name);
 mysqli_set_charset($spojeni, "utf8");

if ($conn->connect_error) {
    die('Chyba při navazování spojení s databází: ' . $conn->connect_error);
}