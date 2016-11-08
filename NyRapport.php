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
		<input type="text" name="EntID" placeholder="EntID.."></p>
		<!-- <input type="text" name="StartDate" placeholder="startDate.."></p>-->
		<input type="text" name="WorkDate" placeholder="yyyy-mm-dd"></p>
		<input type="text" name="Rating" placeholder="Rating.."></p>
		<input type="text" name="Underlay" placeholder="Underlay.."></p>
		<input type="text" name="Edges" placeholder="Edges.."></p>
		<input type="text" name="Grip" placeholder="Grip.."></p>
		<input type="text" name="Depth" placeholder="Depth.."></p>
		<input type="text" name="startName" placeholder="StartName.."></p>
		<input type="text" name="endName" placeholder="EndName.."></p>
		<p><button type="submit" name="_newReport" id="_newReport">NEW Report</button></p></form>

	<?php

	if(isset($_POST['_newReport'])){

    $sql = "CALL _newReport(:newEntID, now(), :newWorkDate, :newRating, :newUnderlay, :newEdges, :newGrip, :newDepth, :startName, :endName)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":newEntID", $_POST['EntID'], PDO::PARAM_INT);

    //$stmt->bindParam(":newStartDate", $_POST['StartDate'], PDO::PARAM_STR);

    $stmt->bindParam(":newWorkDate", $_POST['WorkDate'], PDO::PARAM_STR);

    $stmt->bindParam(":newRating", $_POST['Rating'], PDO::PARAM_INT);

    $stmt->bindParam(":newUnderlay", $_POST['Underlay'], PDO::PARAM_INT);

    $stmt->bindParam(":newEdges", $_POST['Edges'], PDO::PARAM_INT);

    $stmt->bindParam(":newGrip", $_POST['Grip'], PDO::PARAM_INT);

    $stmt->bindParam(":newDepth", $_POST['Depth'], PDO::PARAM_INT);

    $stmt->bindParam(":startName", $_POST['startName'], PDO::PARAM_INT);

    $stmt->bindParam(":endName", $_POST['endName'], PDO::PARAM_INT);

    $stmt->execute();
}
	    
?>
</div>



<div>
    	<h3>Utskrift av rapporter</h3>
    <table>
	    <?php  	
	    		echo "<tr>";
		        echo "<th>reportID</th>"; 
		        echo "<th>newEntID</th>"; 
		        echo "<th>newStartDate</th>"; 
		        echo "<th>newWorkDate</th>"; 
		        echo "<th>newRating</th>"; 
		        echo "<th>newUnderlay</th>"; 
		        echo "<th>newEdges</th>"; 
		        echo "<th>newGrip</th>"; 
		        echo "<th>newDepth</th>";
		        echo "<th>Sträcka</th>"; 
		        echo "</tr>";

//newEntID, newStartDate, newWorkDate, newRating, newUnderlay, newEdges, newGrip, newDepth, startName, endName

		      foreach($pdo->query( 'SELECT * FROM Reporting;' ) as $row){
		        //echo "<tr><td>";
		        //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
		        echo "<tr>";
		        echo "<td>".$row['reportID']."</td>";
		        echo "<td>".$row['entID']."</td>";
		        echo "<td>".$row['startDate']."</td>";
		        echo "<td>".$row['workDate']."</td>";
		        echo "<td>".$row['rating']."</td>";
		        echo "<td>".$row['underlay']."</td>";
		        echo "<td>".$row['edges']."</td>";
		        echo "<td>".$row['grip']."</td>";
		        echo "<td>".$row['depth']."</td>";
		        echo "<td>".$row['name']."</td>";
		        echo "</tr>";  
	      }
	    ?>
    </table>
</div>

</body>
</html>