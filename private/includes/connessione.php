<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "medcarepro";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Errore connessione DB: " . $conn->connect_error);
}
?>
