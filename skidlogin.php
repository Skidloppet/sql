<?php
session_start();

include 'connect.php';

$pass = $_POST['pass'];
$email = $_POST['email'];


$sql = "select * from AllUsers WHERE password='$pass' and email='$email'";
$result = $conn->query($sql);

if(!$row = $result->fetch_assoc()) {
	ECHO "wrong email or password";

} else {

	#$_SESSION['ids'] = array($row['type'], $row['email']);
	$_SESSION['email'] = $row['email'];
	$_SESSION['type'] = $row['type'];

}

header("Location: loginform.php");