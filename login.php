<!DOCTYPE HTML>
<head>
<meta charset="utf-8">
<html>
<style>
body {
    background-color: papayawhip;
}
div{
	display: block; 
	float: left;
	background-color: gainsboro;
	margin: 20px;
	padding: 20px;
}
table, td, th{
	border:1px solid;
	text-align: center;
	margin: auto;
	border-collapse: collapse;
	padding:2px;

}
tr:hover {
    background-color: #ffff99;
}
</style>
</head>
<body>
<!--
Här kan man skriva kommentarer..

Denna filen är inte klar, vi måste avgöra vilken säkerhetsnivå vi vill ha på hemsidan,

alternativ:
1. enkelt login (ganska osäkert, icke användbart i verkligheten)
2. skapa login utifrån wikihow: create a secure login script in php & mySql


Nedanför kan man skriva php kod..
-->

<?php
include'connect.php';
?>


<div>
	<h3>form 4 login</h3>
	<form action ='login.php' method='POST'>
		<input type='text'  name='email' placeholder='email..'>
		<input type='Password'  name='password' placeholder='password..'>
		<button type='submit'>LOGIN</button>
	</form>
</div>


<?php
session_start();

# $user = $_POST['email'];
# $pass = $_POST['password'];

if(isset($_POST['password'])){

$sql = "call CheckLogin (:CheckEmail, :CheckPass);";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":CheckEmail", $_POST['email'], PDO::PARAM_STR);
    $stmt->bindParam(":CheckPass", $_POST['password'], PDO::PARAM_STR);
   	$stmt->execute();
	
	$result = $pdo->prepare($sql);

}

if(!$row = $result->fetch_assoc()) {
  ECHO "wrong username or password";
} else {
$_SESSION['id'] = $row['AgentGroupName'];
}

header("Location: login.php");

?>
<!--
testar med PDO
-->





</body>
</html>