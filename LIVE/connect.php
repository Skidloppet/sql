<?php

# include_once 'psl-config.php';   // As functions.php is not included


	$pdo = new PDO('mysql:dbname=SlitABSkidloppet;host=localhost','sqllab','Tomten2009');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $pdo->exec('set names utf8');


// $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

    $conn = mysqli_connect("localhost","sqllab","Tomten2009",'SlitABSkidloppet');
if (!$conn) {
	die("Connection failed:".mysqli_connect_error());
}

