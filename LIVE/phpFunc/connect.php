<?php

# include_once 'psl-config.php';   // As functions.php is not included


	$pdo = new PDO('mysql:dbname=SlitABSkidloppet;host=localhost','admin','pass');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

// $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

    $conn = mysqli_connect("localhost","admin","pass",'SlitABSkidloppet');
if (!$conn) {
	die("Connection failed:".mysqli_connect_error());
}