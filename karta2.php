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
/*span.dropt {border-bottom: thin dotted; background: #ffeedd;}
span.dropt:hover {text-decoration: none; background: #ffffff; z-index: 6; }*/
span.dropt span {position: absolute; left: -9999px;
  margin: 20px 0 0 0px; padding: 3px 3px 3px 3px;
  border-style:solid; border-color:black; border-width:1px; z-index: 6;}
span.dropt:hover span {left: 2%; background: #ffffff;} 
/*span.dropt span {position: absolute; left: -9999px;
  margin: 4px 0 0 0px; padding: 3px 3px 3px 3px; 
  border-style:solid; border-color:black; border-width:1px;}

kommenterade bort lite CSS som verkar överflödig..
  */
span.dropt:hover span {margin: 20px 0 0 170px; background: #ffffff; z-index:6;} 

</style>
</head>
<body>
<?php
include'connect.php';
?>
<!--
README

Denna är gjord specifikt för Milad då länkarna går till kund sidan,
kanske behöver göra en kopia av denna som vi har på ent/ski sidan
eller en if-sats som kollar som vem man är inloggad(eller vilken roll).
lite smaksak vad man väljer att köra på.

if !isset(session_id) {
	kör denna koden som länkar till kundvyn för de som inte är inloggade.
} elseif ( isset(session_id) && session_role='arenachef'){
	kör kod som länkar till arenachef-vyn
} else if ( isset(session_id) && session_role='other'))
	kör kod som länkar till Ski-användare/Entrepenör
}

popup stulet från..
http://www.scientificpsychic.com/etc/css-mouseover.html

-->

<div>
	<a href="entDetaljer.php">entDetaljer.php</a>
</div>

		<div>
			<?php
			//skapar en loop som sätter in resultaten från frågan som objekt i två arrayer.
			foreach($pdo->query( 'select * from karta order by rspName;' ) as $row){
					    $SubPlaceNameArray[] = $row['rspName']; 
					    $RatingArray[] = $row['rating'];
					}
/*  tror inte det behövs popup för ski/ent?

			foreach($pdo->query( 'select * from KundDetaljer order by rspName;' ) as $row){
					    $popUnderlay[] = $row['underlay']; 
					    $popEdges[] = $row['edges']; 
					    $popGrip[] = $row['grip']; 
					    $popDepth[] = $row['depth']; 
					    $popLength[] = $row['length']; 
					    $popHeight[] = $row['height']; 
					    $popRealname[] = $row['realname']; 
					    $popRating[] = $row['rating']; 
					}
*/
			//testart att skriva ut arrayerna.
			print_r($SubPlaceNameArray);
			echo "</br>";
			print_r($RatingArray);
			echo "</br>";
			echo "<h3>kanske är bättre att skapa en multidimentionell array?!</h3>";
			echo 'exempel: $cars = array (array("Volvo",22,18), array("BMW",15,13), array("Saab",5,2), array("Land Rover",17,15));';
			echo "</br></br></br>";

			// span skiten är för hover...
		// echo "<span class='dropt'>";
			// skapar en länk och skickar till kundDetaljer, samt skriver ut betyget.
			echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[0]."'>delsträcka # ".$SubPlaceNameArray[0]."</a> med rating: ".$RatingArray[0]."</br>";
			/*
			echo "<span>";
			echo "<b>Name: </b>".$popRealname[0]."</br>";
			echo "<b>M.Ö.H: </b>".$popHeight[0]."</br>";
			echo "<b>Längd(m): </b>".$popLength[0]."</br>";
			echo "<b>Betyg: </b>".$popRating[0]."</br>";
			echo "<b>Snödjup: </b>".$popDepth[0]."</br>";
			echo "<b>Underlag: </b>".$popUnderlay[0]."</br>";
			echo "<b>Spårkanter: </b>".$popEdges[0]."</br>";
			echo "<b>Stavfäste: </b>".$popGrip[0]."</br>";
			echo "</span></span>";
			*/
			echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[1]."'>delsträcka # ".$SubPlaceNameArray[1]."</a> med rating: ".$RatingArray[1]."</br>";
			echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[2]."'>delsträcka # ".$SubPlaceNameArray[2]."</a> med rating: ".$RatingArray[2]."</br>";
			echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[3]."'>delsträcka # ".$SubPlaceNameArray[3]."</a> med rating: ".$RatingArray[3]."</br>";
			echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[4]."'>delsträcka # ".$SubPlaceNameArray[4]."</a> med rating: ".$RatingArray[4]."</br>";
			echo "<a href='kundDetaljer.php?DS=".$SubPlaceNameArray[5]."'>delsträcka # ".$SubPlaceNameArray[5]."</a> med rating: ".$RatingArray[5]."</br>";
			?>	
		</div>
	</body>
</html>