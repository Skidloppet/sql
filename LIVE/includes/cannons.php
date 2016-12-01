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
samt kör en session på sidan, behovs dock ej på inkuderade sidor som headerbox samt feeeds! (behåller inlogg för användare med cachat minne i ens webbläsare)
Skapar variabler för enklare åtkompst & frågor som är anpassat för användaren (email för identiskt innehåll )  (type för kontroll av roll, se vyn #1 samt skidlogin.php )
______________
______________
googla: fa fa
där hittas alla stlye alternativ dessa måste implementeras

Dessa 2 divvar är ramen för innehållet med 
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

											<div>
												<p>Change location</p>
												<select>
													<option value="selected">select track</option>
													<?php  
													foreach($pdo->query( 'SELECT * FROM SubPlace where SubPlace.placeName = "Delstrackor" or SubPlace.placeName = "Garage";' ) as $row){
														echo '<option name="name" value="'.$row['name'].'">';
														echo $row['realName'];      
														echo '</option>'; 
													} 
													?> 
												</select> 
												<br></br>
												<p>info till ent</p>
												<form action='backend_cannon.php' method='POST'>
													<textarea rows="3" cols="70" name="info" placeholder="info..."></textarea>	

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
															$sql = "call _newCannonOrder (:cannonID,:name,:entID,:newStatus,:info);";

															echo $_POST['selected'];
															echo $_POST['cannonID'];
															echo "wolo";
															echo $_POST['name'];

															$stmt = $pdo->prepare($sql);
															$stmt->bindParam(":cannonID", $_POST['selected'], PDO::PARAM_INT);
															$stmt->bindParam(":name", $_POST['selected'], PDO::PARAM_INT);
															$stmt->bindParam(":entID", $_POST['entID'], PDO::PARAM_INT);
															$stmt->bindParam(":newStatus", $_POST['state'], PDO::PARAM_STR);
															$stmt->bindParam(":info", $_POST['info'], PDO::PARAM_STR);
															$stmt->execute();
														}

														?>
													</div>
												</div>

