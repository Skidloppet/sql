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

Nedanför kan man skriva php kod..
-->


<div>
	<a href="kundDetaljer.php">kundDetaljer.php</a>
</div>





<div>
<?php
	foreach($pdo->query( 'select * from karta order by rspName;' ) as $row){
			    $SubPlaceNameArray[] = $row['rspName']; 
			    $RatingArray[] = $row['rating'];


	}
	print_r($SubPlaceNameArray);
	echo "</br>";
	print_r($RatingArray);
	echo "</br>";
	echo "<h3>kanske är bättre att skapa en multidimentionell array?!</h3>";
	echo 'exempel: $cars = array (array("Volvo",22,18), array("BMW",15,13), array("Saab",5,2), array("Land Rover",17,15));';
	echo "</br></br></br>";


	echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[0]."'>delsträcka # ".$SubPlaceNameArray[0]."</a> med rating: ".$RatingArray[0]."</br>";
	echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[1]."'>delsträcka # ".$SubPlaceNameArray[1]."</a> med rating: ".$RatingArray[1]."</br>";
	echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[2]."'>delsträcka # ".$SubPlaceNameArray[2]."</a> med rating: ".$RatingArray[2]."</br>";
	echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[3]."'>delsträcka # ".$SubPlaceNameArray[3]."</a> med rating: ".$RatingArray[3]."</br>";
	echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[4]."'>delsträcka # ".$SubPlaceNameArray[4]."</a> med rating: ".$RatingArray[4]."</br>";
	echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[5]."'>delsträcka # ".$SubPlaceNameArray[5]."</a> med rating: ".$RatingArray[5]."</br>";

?>
</div>
</body>
</html>