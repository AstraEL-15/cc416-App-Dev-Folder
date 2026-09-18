<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$host = "localhost";
$user = "root";
$password = "";
$database = "lab_app";

$connection = new mysqli($host, $user, $password, $database);

if($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>