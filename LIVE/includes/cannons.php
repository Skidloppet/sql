<!DOCTYPE html>
<?php
include'../connect.php';
SESSION_START();
$id = $_SESSION['id'];
$em = $_SESSION['email'];
$ty = $_SESSION['type'];
?>
<!--
Ovan inkluderas connectfilen som ligger i mappen LIVE
samt k�r en session p� sidan, behovs dock ej p� inkuderade sidor som headerbox samt feeeds! (beh�ller inlogg f�r anv�ndare med cachat minne i ens webbl�sare)
Skapar variabler f�r enklare �tkompst & fr�gor som �r anpassat f�r anv�ndaren (email f�r identiskt inneh�ll )  (type f�r kontroll av roll, se vyn #1 samt skidlogin.php )
______________
______________
googla: fa fa
d�r hittas alla stlye alternativ dessa m�ste implementeras

Dessa 2 divvar �r ramen f�r inneh�llet med 
-->

<div class="w3-container w3-section">
	<div class="w3-row-padding" style="margin:0 -16px">




		<?php
		if (!isset($_SESSION['email'])) {
			?>
			<a href="Kund.php">
				<h3>logga in</h3>
			</a>
			<?php 
		} 
		elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {

			include 'cannons/co_headerbox_arenachef.php';
			?>
			<div class="w3-container w3-section">
				<div class="w3-row-padding" style="margin:0 -16px">
					<div class="w3-threethird">
						<?php
						include 'cannons/co_feeds_arenachef.php';
					}
					elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'other')) {

						include 'cannons/co_headerbox_other.php';
						?>
						<div class="w3-container w3-section">
							<div class="w3-row-padding" style="margin:0 -16px">
								<div class="w3-threethird">
									<?php
									include 'cannons/co_feeds_other.php';
								}
								elseif (isset($_SESSION['email'])&&($_SESSION['type'] > '1')) {

									include 'cannons/co_headerbox_ent.php';
									?>
									<div class="w3-container w3-section w3-blue">
										<div class="w3-row-padding" style="margin:0 -16px">
											<div class="w3-threethird">
												<?php
												include 'cannons/co_feeds_ent.php';
											}
											else{
												echo "if this message is showing your logged in as a hacker or smt";
											}

											?>

											<div class="w3-threethird">
												<?php  //include './backend_feeds.php';  ?>
											</div>


											<!-- Funkar ej -->
