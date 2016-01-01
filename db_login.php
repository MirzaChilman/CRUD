<?php
//File  : db_login.php
//Deskripsi : menyimpan parameter untuk koneksi ke database

$db_host='localhost';
$db_database='db_mhs';
$db_username='root';
$db_password='';
$conn = new mysqli($db_host, $db_username, $db_password, $db_database);
?>