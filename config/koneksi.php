<?php

$host = getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost';
$user = getenv('DB_USERNAME') ? getenv('DB_USERNAME') : 'root'; 
$pass = getenv('DB_PASSWORD') ? getenv('DB_PASSWORD') : '';     
$db   = getenv('DB_DATABASE') ? getenv('DB_DATABASE') : 'db_sakustat'; 

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {

    die("Koneksi gagal: " . mysqli_connect_error());
}
?>