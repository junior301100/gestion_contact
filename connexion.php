<?php
$host = "sql100.infinityfree.com";
$user = "if0_39533743";
$password = "Curryjr301100";  
$database = "if0_39533743_mycontact";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
?>