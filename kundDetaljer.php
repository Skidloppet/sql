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
README!

vi måste göra så att länken från kartan avgör vilken del-sträcka man får information om.

-->
<?php
include'connect.php';
?>
<div>
	<a href="karta.php">karta.php</a>
</div>

	<div>
		<h3>skriver bara ut den som en enkel tabell för test</h3>
		<table>

		<?php

		    if(isset($_GET['DS'])){
		      
		        $query='SELECT * FROM KundDetaljer where rspName = :DS';
		        $stmt = $pdo->prepare($query);
		        $stmt->bindParam(':DS', $_GET['DS']);
		        $stmt->execute();

			foreach($stmt as $key => $row){
					echo '<tr>';
					echo "<td>".$row['rspName']."</td>";
					echo "<td>".$row['startDate']."</td>";
					echo "<td>".$row['rating']."</td>";
					echo "<td>".$row['underlay']."</td>";
					echo "<td>".$row['edges']."</td>";
					echo "<td>".$row['grip']."</td>";
					echo "<td>".$row['depth']."</td>";
					echo "<td>".$row['length']."</td>";
					echo "<td>".$row['height']."</td>";
					echo "<td>".$row['realname']."</td>";
					echo "</tr>";	
					}
				}
				echo "</table>";
		?>
	</div>
</body>
</html>

</body>
</html>