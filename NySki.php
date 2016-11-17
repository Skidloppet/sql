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

Nedanför kan man skriva php kod..
-->

<?php
include'connect.php';
?>

<div>
	<h3>Create new Ski</h3>
	<form action='<?php $_PHP_SELF ?>' method='POST'>
		<input type="text" name="firstName" placeholder="first name..">
		<input type="text" name="lastName" placeholder="surname..">
		<input type="text" name="email" placeholder="email..">
		<input type="text" name="number" placeholder="number..">
		<input type="text" name="type" placeholder="type..">
		<input type="text" name="pass" placeholder="password..">
		<button type="submit" name="CreateSki" id="CreateSki">NEW SKI</button>
	</form>


	<?php

	if(isset($_POST['CreateSki'])){

    $sql = "CALL CreateSki( :pass, :firstName, :lastName , :email, :number, :type)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":pass", $_POST['pass'], PDO::PARAM_STR);
    $stmt->bindParam(":firstName", $_POST['firstName'], PDO::PARAM_STR);
    $stmt->bindParam(":lastName", $_POST['lastName'], PDO::PARAM_STR);
    $stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
    $stmt->bindParam(":number", $_POST['number'], PDO::PARAM_INT);
    $stmt->bindParam(":type", $_POST['type'], PDO::PARAM_STR);
   	$stmt->execute();
	}	    
?>
</div>

<div>
	<h3>Utskrift av Entrepenörer</h3>
    	<table>
	    	<tr>
		        <th>skiID</th>
		        <th>First Name</th>
		        <th>Surname</th>
		        <th>email adress</th>
		        <th>tel number</th>
		        <th>type</th>
		        <th>password</th>
		    </tr>
	    <?php 
	      foreach($pdo->query( 'SELECT * FROM Ski;' ) as $row){
	        echo "<tr>";
	        echo "<td>".$row['skiID']."</td>";
	        echo "<td>".$row['firstName']."</td>";
	        echo "<td>".$row['lastName']."</td>";
	        echo "<td>".$row['email']."</td>";
	        echo "<td>".$row['number']."</td>";
	        echo "<td>".$row['type']."</td>";
	        echo "<td>".$row['password']."</td>";
	        echo "</tr>";  
	    }
      ?>
</div>

</body>
</html>