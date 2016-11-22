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
test
Nedanför kan man skriva php kod..
-->
<?php
include'connect.php';
?>
<?php
			
	if(isset($_GET['orderID'])){
			 $querystring='DELETE FROM WorkOrder WHERE orderID = :orderID';
			 $stmt = $pdo->prepare($querystring);
			 $stmt->bindParam(':orderID', $_GET['orderID']);
			 $stmt->execute();
			 echo "Arbetsorder borttagen";
		}
		
	

?>
<table>
<tr>
<td>orderID</td>
<td>skiID</td>
<td>entID</td>
<td>sentDate</td>
<td>endDate</td>
<td>priority</td>
<td>Delete</td>
</tr>

	
<?php
	foreach($pdo->query( 'SELECT * FROM WorkOrder;' ) as $row){
			echo '<tr>';
			echo "<td>".$row['orderID']."</td>";
			echo "<td>".$row['skiID']."</td>";
			echo "<td>".$row['entID']."</td>";
			echo "<td>".$row['sentDate']."</td>";
			echo "<td>".$row['endDate']."</td>";
			echo "<td>".$row['priority']."</td>";
			echo "<td><a href='delete.php?orderID=".$row['orderID']."'>Ta bort</a></td>";
			echo "</tr>";	
		}
		
		echo "</table>";
?>
</body>
</html>

</body>
</html>