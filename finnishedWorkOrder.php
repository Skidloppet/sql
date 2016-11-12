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
<!--
Här kan man skriva kommentarer..

detta är en procedure för avklarade arbetsordrar
Nedanför kan man skriva php kod..
-->


<div>
<h1>wowo</h1>
</div>


	<div>
		<h3>finnish workorder</h3>
		<h3>KOMMENTAREN KOMMER EJ MED!</h3>
		<h3>GÅ IGENOM DEN FELAKTIGA PROCEDUREN!</h3>

		<form action='<?php $_PHP_SELF ?>' method='POST'>
			<input type="text" name="orderID" placeholder="orderID..">
			<input type="text" name="entID" placeholder="entID..">
			<input type="text" name="EntComment" placeholder="kommentar..">
			<button type="submit" name="finnished">submit</button>
		</form>

		<?php

		if(isset($_POST['finnished'])){

		    $sql = "CALL _finnishedWorkOrder(:finnishedOrderID , :finnishedEntID , now() , :finnishedComment);";

		    $stmt = $pdo->prepare($sql);

		    $stmt->bindParam(":finnishedOrderID", $_POST['orderID'], PDO::PARAM_INT);

		    $stmt->bindParam(":finnishedEntID", $_POST['entID'], PDO::PARAM_INT);

		    $stmt->bindParam(":finnishedComment", $_POST['EntComment'], PDO::PARAM_STR);

		    $stmt->execute();
			
			}
		    
		?>
	</div>



<div>
	<h3>Utskrift av workorder(arbetsorder)</h3>
    <table>
	    <?php  
		        echo "<th>orderID</th>"; 
		        echo "<th>skiID</th>"; 
		        echo "<th>entID</th>"; 
		        echo "<th>sentDate</th>"; 
		        echo "<th>endDate</th>"; 
		        echo "<th>priority</th>"; 
		        echo "<th>info</th>"; 
		      foreach($pdo->query( 'SELECT * FROM WorkOrder;' ) as $row){
		        echo "<tr><td>";
		        echo "<a href='finnishedWorkOrder.php?orderID=".urlencode($row['orderID'])."'>".$row['orderID']."</td>";
		        echo "<td>".$row['skiID']."</td>";
		        echo "<td>".$row['entID']."</td>";
		        echo "<td>".$row['sentDate']."</td>";
		        echo "<td>".$row['endDate']."</td>";
		        echo "<td>".$row['priority']."</td>";
		        echo "<td>".$row['info']."</td>";
		        echo "</tr>";  
	      }
	    ?>
    </table>

</div>



<div>
	<h3>Utskrift av avklarat arbete</h3>
    <table>
	    <?php  
		        echo "<th>orderID</th>"; 
		        echo "<th>entID</th>"; 
		        echo "<th>sentDate</th>"; 
		        echo "<th>endDate</th>"; 
		        echo "<th>priority</th>"; 
		        echo "<th>EntComment</th>"; 
		      foreach($pdo->query( 'SELECT * FROM FinnishedWorkOrder;' ) as $row){
		        echo "<tr><td>";
		        echo "<a href='finnishedWorkOrder.php?orderID=".urlencode($row['orderID'])."'>".$row['orderID']."</td>";
		        echo "<td>".$row['entID']."</td>";
		        echo "<td>".$row['sentDate']."</td>";
		        echo "<td>".$row['endDate']."</td>";
		        echo "<td>".$row['priority']."</td>";
		        echo "<td>".$row['EntComment']."</td>";
		        echo "</tr>";  
	      }
	    ?>
    </table>
</div>



</body>
</html>