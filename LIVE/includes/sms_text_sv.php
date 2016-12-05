<?php
include '../connect.php';
/**
 * Integration mot Cellsynts SMS gateway via HTTP-gränssnitt
 * Skicka textmeddelande
 */
#foreach ($pdo->query('SELECT number FROM Ent WHERE entID >1 AND entID <=7') as $tel) { echo $tel['number'].','; }

// Stäng av felmeddelanden
ini_set("display_errors", "off");

$sms_url = "http://se-1.cellsynt.net/sms.php";		// Gateway URL

$username = "sebastianpersic";						// Kontots användarnamn
$password = "Kot1tUUf";								// Kontots lösenord

$type = "text";										// Meddelandetyp
$originatortype = "alpha";							// Avsändartyp (alpha = Alfanumerisk, numeric = Numerisk, shortcode = Operatörskortkod)
$originator = "Skidloppet";						    // Avsändare

$destination = "0046703713943";						// Mottagarens mobiltelefonnummer på internationellt format, i detta exempel SE
$text = "Akut AO Typ: ".$_POST['type']." Start: ".$_POST['Start']." Slut: ".$_POST['Slut']." Besk: ".$_POST['info1']; // Meddelandetext, deklareras i wo_headerbox_arenachef.php
$charset = "UTF-8";
$allowconcat = "2";

// GET-parametrar
$parameters  = "username=$username&password=$password";
$parameters .= "&type=$type&originatortype=$originatortype&originator=" . urlencode($originator);
$parameters .= "&destination=$destination&text=" . urlencode($text);

// Skicka HTTP-anrop
//Ligger i if-sats för akuta ordrar i wo_headerbox_arenachef.php


// Kontrollera svar
if ($response === false) {
	echo "Anrop kunde inte skickas.";
}
elseif (substr($response, 0, 4) == "OK: ") {
	$trackingid = substr($response, 4);
	echo "SMS skickat med tracking ID: " . $trackingid . "\n";
}
elseif (substr($response, 0, 7) == "Error: ") {
	echo "Ett fel uppstod, servern skickade följande svar: " . $response;
}

?>

