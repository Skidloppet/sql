<?php 
$i = 0;
$i2 = 0;

foreach($pdo->query( 'select count(*)as i from Report;') as $row){
	$i = $row['i'];
}
foreach($pdo->query( 'select count(*)as i from StoredReports;') as $row){
	$i2 = $row['i'];
}
?>

<header class="w3-container" style="padding-top:22px">
	<style>
		.HoverButton:hover { background: Red; }
		.HoverButton2:hover { background: Green; }
	</style>
</header>

<div class="w3-row-padding w3-margin-bottom">

	<div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id01').style.display='block'">
		<div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-red w3-padding-16">
			<div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
			<div class="w3-right">
				<h3><br></h3>
			</div>
			<div class="w3-clear"></div>
			<h4>Ändra ansvar över delsträcka</h4>
		</div>
	</div>

<a href="#12">
	<div class="w3-third">
		<div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-blue w3-padding-16">
			<div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
			<div class="w3-right">
				<h3><?php print_r($i); ?></h3>
			</div>
			<div class="w3-clear"></div>
			<h4>Alla delsträckor</h4>
		</div>
	</div>
</a>

	<!-- Popup till SKAPA RAPPORT -->

	<div id="id01" class="w3-modal">
		<div class="w3-modal-content">
			<div class="w3-container">
				<span onclick="document.getElementById('id01').style.display='none'"
				class="w3-closebtn">&times;</span>
				<!-- Start av innehåll/Formen -->
				<div id="11" class="w3-container">

					<h3>Ny ansvarig entreprenör över delsträcka</h3>
					
					<form id="ChangeSubEnt">
						<p>Delsträcka/Plats:
							<select name='Start'>    
								<?php 
								foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
									echo '<option value="'.$row['name'].'">';
									echo $row['realName'];
									echo "</option>";
								}
								?></select>

								Ny ansvarig:
									<select name='Ent'>    
										<?php 
										foreach ($pdo->query('SELECT * FROM Ent') as $row) {
											echo '<option value="'.$row['entID'].'">';
											echo $row['firstName']." ".$row['lastName'];
											echo "</option>";
										}
										?> 
									</select>
									<button type="button" onclick="SendForm('subplace', 'subplace', 'ChangeSubEnt');">Spara ändring</button></p></form>

									<br>
									<h3>Alla delsträckor och den ansvarige</h3>

										<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
											<?php   
											echo "<tr>";
											echo "<th>Plats</th>"; 
											echo "<th>Entreprenör</th>"; 
											echo "</tr>";

											foreach ($pdo->query('
												SELECT *
												from SubPlaceViewer;
												')as $row) {

												echo "<tr>";
											echo "<td>".$row['realName']."</td>";
											echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
											?>
											</tr><?php } ?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php
				if(isset($_POST['Ent'])){
					$sql = "call _newResponsabilitySubPlace (:_entID,:_name)";
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(":_entID", $_POST['Ent'], PDO::PARAM_INT);
					$stmt->bindParam(":_name", $_POST['Start'], PDO::PARAM_INT);
					$stmt->execute();
				}    
				?>