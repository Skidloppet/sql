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
	<h3>Add a new workorder</h3>
	<form action='<?php $_PHP_SELF ?>' method='POST'>
		<input type="text" name="SkiID" placeholder="SkiID.."></p>
		<input type="text" name="EntID" placeholder="EntID.."></p>
		<input type="text" name="Prioritering" placeholder="Prioritering..(low,akut)"></p>
		<input type="text" name="type" placeholder="type (tracks, trees osv.)"></p>
		<input type="text" name="Info" placeholder="Info.."></p>
		<input type="checkbox" name="split" value="1">split order for each track 'owner' <br>
		<input type="text" name="Start" placeholder="Start.."></p>
		<input type="text" name="Slut" placeholder="Slut.."></p>
		<p><button type="submit" name="_newSplitWorkOrder" id="_newWorkOrder">NEW Report</button></p></form>


	<?php

	if(isset($_POST['_newSplitWorkOrder'])){

    $sql = "CALL _newSplitWorkOrder(:newSkiID, :newEntID, NOW() ,:newPriority, :newType, :newInfo, :newSplit, :startName, :endName)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":newSkiID", $_POST['SkiID'], PDO::PARAM_INT);
    $stmt->bindParam(":newEntID", $_POST['EntID'], PDO::PARAM_INT);
    $stmt->bindParam(":newPriority", $_POST['Prioritering'], PDO::PARAM_STR);
    $stmt->bindParam(":newType", $_POST['type'], PDO::PARAM_STR);
    $stmt->bindParam(":newInfo", $_POST['Info'], PDO::PARAM_STR);
    $stmt->bindParam(":newSplit", $_POST['split'], PDO::PARAM_INT);
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
	</div>

<div>
    	<h3>Utskrift av workorder(rapport)</h3>
    <table>
	    <?php  	
	    		echo "<tr>";
		        echo "<th>orderID</th>"; 
		        echo "<th>skiID</th>"; 
		        echo "<th>entID</th>"; 
		        echo "<th>sentDate</th>"; 
		        echo "<th>startDate</th>"; 
		        echo "<th>priority</th>"; 
		        echo "<th>type</th>"; 
		        echo "<th>info(ski)</th>"; 
		        echo "<th>comment(ent)</th>"; 
		        echo "</tr>";
		      foreach($pdo->query( 'SELECT * FROM WorkOrder;' ) as $row){
		        //echo "<tr><td>";
		        //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
		        echo "<tr>";
		        echo "<td>".$row['orderID']."</td>";
		        echo "<td>".$row['skiID']."</td>";
		        echo "<td>".$row['entID']."</td>";
		        echo "<td>".$row['sentDate']."</td>";
		        echo "<td>".$row['endDate']."</td>";
		        echo "<td>".$row['priority']."</td>";
		        echo "<td>".$row['type']."</td>";
		        echo "<td>".$row['info']."</td>";
		        echo "<td>".$row['EntComment']."</td>";
		        echo "</tr>";  
	      }

	    ?>
    </table>
</div>

</body>
</html>