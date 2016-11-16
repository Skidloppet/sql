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
	<h3>Create new Ent</h3>
	<form action='<?php $_PHP_SELF ?>' method='POST'>
		<input type="text" name="firstName" placeholder="first name.."></p>
		<input type="text" name="lastName" placeholder="surname.."></p>
		<input type="text" name="email" placeholder="email.."></p>
		<input type="text" name="number" placeholder="number.."></p>
		<input type="password" name="pass" placeholder="password.."></p>
		<p><button type="submit" name="CreateEnt" id="CreateEnt">NEW Report</button></p></form>


	<?php
	# skapa ett errormedelande vid fel input (email, number)

	if(isset($_POST['CreateEnt'])){

    $sql = "CALL CreateEnt(:pass, :firstName, :lastName ,:email, :number)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":pass", $_POST['pass'], PDO::PARAM_STR);
    $stmt->bindParam(":firstName", $_POST['firstName'], PDO::PARAM_STR);
    $stmt->bindParam(":lastName", $_POST['lastName'], PDO::PARAM_STR);
    $stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
    $stmt->bindParam(":number", $_POST['number'], PDO::PARAM_INT);
    $stmt->execute();
}	    
?>
</div>


<div>
	<h3>Utskrift av Entrepenörer</h3>
    <table>
	    <?php  	
	    		echo "<tr>";
		        echo "<th>entID</th>"; 
		        echo "<th>First Name</th>"; 
		        echo "<th>Last Name</th>"; 
		        echo "<th>email adress</th>"; 
		        echo "<th>tel number</th>"; 
		        echo "<th>password</th>"; 

		        echo "</tr>";
		      foreach($pdo->query( 'SELECT * FROM Ent;' ) as $row){
		        //echo "<tr><td>";
		        //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
		        echo "<tr>";
		        echo "<td>".$row['entID']."</td>";
		        echo "<td>".$row['firstName']."</td>";
		        echo "<td>".$row['lastName']."</td>";
		        echo "<td>".$row['email']."</td>";
		        echo "<td>".$row['number']."</td>";
		        echo "<td>".$row['password']."</td>";
		        echo "</tr>";  
		    }
	      ?>
</div>

</body>
</html>