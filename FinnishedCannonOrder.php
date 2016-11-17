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

-->
	<div>
		<h3>finnish CannonOrder</h3>
		<form action='<?php $_PHP_SELF ?>' method='POST'>
			<input type="text" name="orderID" placeholder="orderID..">
			<input type="text" name="entID" placeholder="entID..">
			<input type="text" name="EntComment" placeholder="kommentar..">
			<button type="submit" name="finnished">submit</button>
		</form>

		<?php

		if(isset($_POST['finnished'])){

		    $sql = "CALL _finnishedCannonOrder(:finnishedOrderID , :finnishedEntID , now() , :finnishedComment);";

		    $stmt = $pdo->prepare($sql);
		    $stmt->bindParam(":finnishedOrderID", $_POST['orderID'], PDO::PARAM_INT);
		    $stmt->bindParam(":finnishedEntID", $_POST['entID'], PDO::PARAM_INT);
		    $stmt->bindParam(":finnishedComment", $_POST['EntComment'], PDO::PARAM_STR);
		    $stmt->execute();
			
			}
		    
		?>
	</div>

<div>
	<h3>Utskrift av CannonOrder</h3>
    <table>
	    <?php  
		        echo "<th>orderID</th>"; 
		        echo "<th>CannonID</th>"; 
		        echo "<th>entID</th>"; 
		        echo "<th>name</th>"; 
		        echo "<th>startStamp</th>"; 
		        echo "<th>endStamp</th>"; 
		        echo "<th>newStatus</th>"; 
		        echo "<th>info</th>"; 
		        echo "<th>comment</th>"; 
		      foreach($pdo->query( 'SELECT * FROM CannonSubPlace;' ) as $row){
		        echo "<tr><td>";
		        echo "<a href='FinnishedCannonOrder.php?orderID=".urlencode($row['orderID'])."'>".$row['orderID']."</td>";
		        echo "<td>".$row['cannonID']."</td>";
		        echo "<td>".$row['entID']."</td>";
		        echo "<td>".$row['name']."</td>";
		        echo "<td>".$row['startStamp']."</td>";
		        echo "<td>".$row['endStamp']."</td>";
		        echo "<td>".$row['newStatus']."</td>";
		        echo "<td>".$row['info']."</td>";
		        echo "<td>".$row['comment']."</td>";
		        echo "</tr>";  
	      }
	    ?>
    </table>

</div>

<div>
	<h3>Utskrift av FINNISHEDCannonOrder</h3>
    <table>
	    <?php  
		        echo "<th>orderID</th>"; 
		        echo "<th>CannonID</th>"; 
		        echo "<th>entID</th>"; 
		        echo "<th>name</th>"; 
		        echo "<th>startStamp</th>"; 
		        echo "<th>endStamp</th>"; 
		        echo "<th>newStatus</th>"; 
		        echo "<th>info</th>"; 
		        echo "<th>comment</th>"; 
		      foreach($pdo->query( 'SELECT * FROM FinnishedCannonSubPlace;' ) as $row){
		        echo "<tr><td>";
		        echo "<a href='FinnishedCannonOrder.php?orderID=".urlencode($row['orderID'])."'>".$row['orderID']."</td>";
		        echo "<td>".$row['cannonID']."</td>";
		        echo "<td>".$row['entID']."</td>";
		        echo "<td>".$row['name']."</td>";
		        echo "<td>".$row['startStamp']."</td>";
		        echo "<td>".$row['endStamp']."</td>";
		        echo "<td>".$row['newStatus']."</td>";
		        echo "<td>".$row['info']."</td>";
		        echo "<td>".$row['comment']."</td>";
		        echo "</tr>";  
	      }
	    ?>
    </table>

</div>

</body>
</html>