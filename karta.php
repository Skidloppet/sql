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
<?php
	foreach($pdo->query( 'select * from karta order by rspName;' ) as $row){
			    $SubPlaceNameArray[] = $row['rspName']; 
			    $RatingArray[] = $row['rating'];


	}
	print_r($SubPlaceNameArray);
	echo "</br>";
	print_r($RatingArray);

	echo "</br>Här är delsträcka 1: "."$SubPlaceNameArray[0]".". med rating: "."$RatingArray[0]";
	echo "</br>Här är delsträcka 2: "."$SubPlaceNameArray[1]".". med rating: "."$RatingArray[1]";
	echo "</br>Här är delsträcka 3: "."$SubPlaceNameArray[2]".". med rating: "."$RatingArray[2]";
	echo "</br>Här är delsträcka 4: "."$SubPlaceNameArray[3]".". med rating: "."$RatingArray[3]";
	echo "</br>Här är delsträcka 5: "."$SubPlaceNameArray[4]".". med rating: "."$RatingArray[4]";
	echo "</br>Här är delsträcka 6: "."$SubPlaceNameArray[5]".". med rating: "."$RatingArray[5]";

?>

</body>
</html>