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
	<h3>Add a new report</h3>
	<form action='<?php $_PHP_SELF ?>' method='POST'>
		<input type="text" name="SkiID" placeholder="SkiID.."></p>
		<input type="text" name="EntID" placeholder="EntID.."></p>
		<input type="text" name="Prioritering" placeholder="Prioritering.."></p>
		<input type="text" name="Info" placeholder="Info.."></p>
		<input type="text" name="Start" placeholder="Start.."></p>
		<input type="text" name="Slut" placeholder="Slut.."></p>
		<p><button type="submit" name="_newWorkOrder" id="_newWorkOrder">NEW Report</button></p></form>


	<?php

	if(isset($_POST['_newWorkOrder'])){

    $sql = "CALL _newWorkOrder(:newSkiID, :newEntID, NOW() ,:newPriority, :newInfo, :startName, :endName)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":newSkiID", $_POST['SkiID'], PDO::PARAM_INT);

    $stmt->bindParam(":newEntID", $_POST['EntID'], PDO::PARAM_INT);

    $stmt->bindParam(":newPriority", $_POST['Prioritering'], PDO::PARAM_STR);

    $stmt->bindParam(":newInfo", $_POST['Info'], PDO::PARAM_STR);

    $stmt->bindParam(":startName", $_POST['Start'], PDO::PARAM_INT);

    $stmt->bindParam(":endName", $_POST['Slut'], PDO::PARAM_INT);

    $stmt->execute();
}
	    
?>
</div>



<div>
	<h3>Utskrift av Entrepenörer</h3>
    <table>
	    <?php  
		        echo "<th>entID</th>"; 
		        echo "<th>name</th>"; 
		        echo "<th>surname</th>"; 
		      foreach($pdo->query( 'SELECT * FROM Ent;' ) as $row){
		        echo "<tr><td>";
		        echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
		        echo "<td>".$row['firstName']."</td>";
		        echo "<td>".$row['lastName']."</td>";
		        echo "</tr>";  
	      }
	    ?>
    </table>
    <br><br>
    	<h3>Utskrift av rapporter</h3>
    <table>
	    <?php  	
	    		echo "<tr>";
		        echo "<th>orderID</th>"; 
		        echo "<th>skiID</th>"; 
		        echo "<th>entID</th>"; 
		        echo "<th>sentDate</th>"; 
		        echo "<th>startDate</th>"; 
		        echo "<th>priority</th>"; 
		        echo "<th>info</th>"; 
		        echo "<th>Sträcka</th>"; 
		        echo "</tr>";
		      foreach($pdo->query( 'SELECT * FROM WorkOrdersAndPlaces;' ) as $row){
		        //echo "<tr><td>";
		        //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
		        echo "<tr>";
		        echo "<td>".$row['orderID']."</td>";
		        echo "<td>".$row['skiID']."</td>";
		        echo "<td>".$row['entID']."</td>";
		        echo "<td>".$row['sentDate']."</td>";
		        echo "<td>".$row['startDate']."</td>";
		        echo "<td>".$row['priority']."</td>";
		        echo "<td>".$row['info']."</td>";
		        echo "<td>".$row['name']."</td>";
		        echo "</tr>";  
	      }
	    ?>
    </table>
</div>

</body>
</html>