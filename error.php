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

	fungerar ej..
-->

<?php
include'connect.php';
?>


<div>
	<h3>NEW WORK ORDER</h3>
	<form action='<?php $_PHP_SELF ?>' method='POST'>
		<textarea rows="5" cols="70" name="desc" placeholder="please describe the problem explicit here.."></textarea>
		</br>
		<p>Ange graden av problemets påverkan</p>

		<select name='grade'>
			<option selected="selected"> Sätt nivå</option>
			<option value="low">Lågt - Påverkar knappt</option>
			<option value="medium">Medium - Påverkar en del</option>
			<option value="high">Hög - Påverkar mycket</option>
			<option value="akut">Akut - Grovt problem</option>
		</select>
		<input type="text" name="type" placeholder="type.."></p>
		<input type="text" name="entID" placeholder="entID.."></p>
		<input type="text" name="Start" placeholder="Start.."></p>
		<input type="text" name="Slut" placeholder="Slut.."></p>
		<p><button type="submit" name="Error">NEW Report</button></p></form>


	<?php

	if(isset($_POST['Error'])){

    $sql = "CALL _NewError(:newErrorDesc, :newEntID, NOW() , :newGrade, :newType, :startName, :endName);";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":newErrorDesc", $_POST['desc'], PDO::PARAM_STR);
    $stmt->bindParam(":newEntID", $_POST['entID'], PDO::PARAM_INT);
    $stmt->bindParam(":newGrade", $_POST['grade'], PDO::PARAM_STR);
    $stmt->bindParam(":newType", $_POST['type'], PDO::PARAM_STR);
    $stmt->bindParam(":startName", $_POST['Start'], PDO::PARAM_INT);
    $stmt->bindParam(":endName", $_POST['Slut'], PDO::PARAM_INT);
    $stmt->execute();
}    
?>
</div>


<div>
	<h3>Utskrift av Ent's nästa beräknade arbetspass</h3>
    <table>
	    <?php  
		        echo "<th>Next Date (estimated)</th>"; 
		        echo "<th>Name</th>";

		      foreach($pdo->query( 'select workDate, firstName, lastName from Report,Ent where Report.entID = Ent.entID group by Ent.EntID;' ) as $row){
		        echo "<tr>";
		        echo "<td>".$row['workDate']."</td>";
		        echo "<td>".$row['firstName']." ".$row['lastName']."</td>";

		        echo "</tr>";  
	      }
	    ?>
    </table>
</div>
</body>
</html>