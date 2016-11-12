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

<?php
include'connect.php';
?>

<div>
	<h3>Create new cannon</h3>
	<form action='<?php $_PHP_SELF ?>' method="post">
		<select size='1' name='status'>
			<option > status cannon</option>
			<option value="on"> On</option>
			<option value="off"> Off</option>
			<option value="broken"> broken</option>
			<option value="unplugged"> unplugged</option>
		</select><br></br>
		<input type="text" name="subPlaceName" placeholder="plats.."></p>
		<input type="text" name="model" placeholder="modell.."></p>
		<input type="text" name="effect" placeholder="effekt.."></p>
		<input type="submit" value="Lägg till"/>


<?php

    if(isset($_POST['subPlaceName'])){
        $sql="CALL NewCannon(:subPlaceName,:model,:status,:effect)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':subPlaceName', $_POST['subPlaceName'],PDO::PARAM_INT);
        $stmt->bindParam(':model', $_POST['model'],PDO::PARAM_STR);
        $stmt->bindParam(':status', $_POST['status'],PDO::PARAM_STR);
		$stmt->bindParam(':effect', $_POST['effect'],PDO::PARAM_INT);
        $stmt->execute();
    }
	?>
    </div>

 <div>
    <h3>Kanoner!</h3>
	<table>
	 <tr>
	 <th>subPlaceName</th> 
	 <th>model</th>
     <th>status</th>
	 <th>effect</th>
	 </tr>
	 <?php
    foreach($pdo->query( 'SELECT * FROM Cannon;' ) as $row){
      echo "<tr>";
      echo "<td>".$row['subPlaceName']."</td>";
      echo "<td>".$row['model']."</td>";
      echo "<td>".$row['status']."</td>";
      echo "<td>".$row['effect']."</td>";
      echo "</tr>"; 
    }
?>
</table>
</div>
</body>
</html>
 