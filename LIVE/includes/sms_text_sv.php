<?php
include '../connect.php';
ini_set("display_errors", "off");
/**
 * Integration mot Cellsynts SMS gateway via HTTP-gränssnitt
 * Skicka textmeddelande
 */
 
$phones = array(); 
foreach ($pdo->query('SELECT number FROM Ent WHERE entID >1 AND entID <=7') as $tel) { $phones[] = $tel['number']; }

// Foreach loopar som tar fram namn för berörda sträckor istället för bara sträckans IDnr
foreach($pdo->query('select realName from SubPlace where name = '.$_POST['Start'].';' ) as $ao1){
                       $ao1['realName'];
                      }
foreach($pdo->query('select realName from SubPlace where name = '.$_POST['Slut'].';' ) as $ao2){
                       $ao2['realName'];
                      }


// Foreach loopar som tar fram namn för var snökanon står och ska flyttas till istället för bara sträckans IDnr
foreach($pdo->query('select subPlaceName from Cannon where cannonID = '.$_POST['cannonID'].';' ) as $cano1){
                       $cano1['subPlaceName'];
                      }
foreach($pdo->query('select realName from SubPlace where name = '.$_POST['name'].';' ) as $cano2){
                       $cano2['realName'];
                      }

					  
					  
$textmsg = "NULL";
$arbetsorder = "Akut arbetsorder\nTyp: ".$_POST['type']."\nStart: ".$ao1['realName']."\nSlut: ".$ao2['realName']."\nBeskrivning:\n".$_POST['info1'];
$snokanoner = "Akut arbetsorder\nSnökanon: ".$_POST['cannonID']."\nNuvarande plats: ".$cano1['subPlaceName']."\nNy plats: ".$cano2['realName']."\nNy status: ".$_POST['state']."\nBeskrivning:\n".$_POST['info2'];
					  
					  
if ($_POST['info1']) {
	$textmsg = $arbetsorder;
}
else {
	$textmsg = $snokanoner;
}


// Stäng av felmeddelanden


$sms_url = "http://se-1.cellsynt.net/sms.php";		// Gateway URL

$username = "sebastianpersic";						// Kontots användarnamn
$password = "Kot1tUUf";								// Kontots lösenord

$type = "text";										// Meddelandetyp
$originatortype = "alpha";							// Avsändartyp (alpha = Alfanumerisk, numeric = Numerisk, shortcode = Operatörskortkod)
$originator = "Skidloppet";						    // Avsändare

$destination = implode(",",$phones);				// Mottagarens mobiltelefonnummer på internationellt format, i detta exempel SE
$text =  $textmsg; // Meddelandetext, deklareras i wo_headerbox_arenachef.php
$charset = "utf-8";
$allowconcat = "2";

// GET-parametrar
$parameters  = "username=$username&password=$password";
$parameters .= "&type=$type&originatortype=$originatortype&originator=" . urlencode($originator);
$parameters .= "&destination=$destination&text=" . urlencode($text);
$parameters .= "&charset=$charset&allowconcat=$allowconcat";

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

