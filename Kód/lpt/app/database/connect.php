<?php

$host = 'localhost';
$user = 'sramek09';
$pass = 'Tis*510230';
$db_name = 'sramek09';

$conn = new MySQLi($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}