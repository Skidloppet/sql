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
<h3>NEW CANNON ORDER</h3>
<table>
	<th>CannonID</th>
	<th>CannonModel</th>
	<th>Cannon current position</th>
	<th>Cannon current status</th>
	<th>Cannon effect</th>
	<th>Select </th>
	<tr>
		<?php
	    foreach($pdo->query( 'SELECT cannonID, model, state, effect, realName  FROM Cannon, SubPlace where SubPlace.name = Cannon.subPlaceName;') as $row){
		    echo "<tr>";
		    echo "<td>".$row['cannonID']."</td>";
		    echo "<td>".$row['model']."</td>";
		    echo "<td>".$row['realName']."</td>";
		    echo "<td>".$row['state']."</td>";
		    echo "<td>".$row['effect']."</td>";
	    	echo '<form><th><input type="checkbox" name="selected" value="'.$row["cannonID"].'"></th>';
	        echo "</tr>";
	    }
		?>
	</tr>
</table>

	<div>
		<p>Change status</p>
    	<select id="selecten"> 
  	        <option value="as">select status</option>
  	        <option name="status" value="on">on</option>
    	    <option name="status" value="off">off</option>
        	<option name="status" value="unplugged">unplugged</option>
            <option name="status" value="broken">broken</option>	   
        	</select>
		</div>
	<div>
   		<p>Change location</p>
        <select class='select1'>
        	<option id="select1"value="selected">select track</option>
		    <?php  
		 	   foreach($pdo->query( 'SELECT * FROM SubPlace where SubPlace.placeName = "Delstrackor" or SubPlace.placeName = "Garage";' ) as $row){
		        echo '<option name="name" value="'.$row['name'].'">';
			    echo $row['realName'];      
			    echo '</option>'; 
				} 
			?> 
        </select>     
	</div>

	<div>
   		<p>Set responsibility (* default = split between owners of tracks)</p>
        <select class='select1'>
        	<option id="select1">default</option>
		    <?php    
		    foreach($pdo->query( 'SELECT * FROM Ent; ' ) as $row){
		        echo '<option name="entID"value="'.$row['entID'].'">';
			    echo $row['firstName']." ".$row['lastName'];      
			    echo '</option>'; } ?> 
        </select>     
 	<input type="submit" name="send">

 <?php

	if(isset($_POST['send'])){
    $sql = "call _newCannonOrder (:cannonID,:name,:entID,:newStatus);";
		
		echo $_POST['selected']."wolo";

	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(":cannonID", $_POST['selected'], PDO::PARAM_INT);
	    $stmt->bindParam(":name", $_POST['name'], PDO::PARAM_INT);
	    $stmt->bindParam(":entID", $_POST['entID'], PDO::PARAM_INT);
	    $stmt->bindParam(":newStatus", $_POST['state'], PDO::PARAM_STR);
	    $stmt->execute();
	}
	    
?>
	</div>
</div>


<div>
	<h3>Utskrift av CANNON ORDERS!(CannonSubPlace)</h3>
    <table>
	    <?php  
		        echo "<th>cannonID</th>"; 
		        echo "<th>name</th>";
		        echo "<th>entID</th>";
		        echo "<th>newStatus</th>";

		      foreach($pdo->query( 'select * from CannonSubPlace;' ) as $row){
		        echo "<tr>";
		        echo "<td>".$row['cannonID']."</td>";
		        echo "<td>".$row['name']."</td>";
		        echo "<td>".$row['entID']."</td>";
		        echo "<td>".$row['newStatus']."</td>";
		        echo "</tr>";  
	      }
	    ?>
    </table>
</div>

</body>
</html>


