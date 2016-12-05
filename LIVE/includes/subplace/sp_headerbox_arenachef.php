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


<div class="w3-row-padding w3-margin-bottom">
	<div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id01').style.display='block'">
		<div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-cyan w3-padding-16">
			<div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
			<div class="w3-right">
			</div>
			<div class="w3-clear"></div>
			<h5>Ändra ansvar över delsträcka</h5>
		</div>
	</div>

	<div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id02').style.display='block'">
		<div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-cyan w3-padding-16">
			<div class="w3-left"><i class="fa fa-minus w3-xxxlarge"></i></div>
			<div class="w3-right">
			</div>
			<div class="w3-clear"></div>
			<h5>Nollställ konstsnö på valfri delsträcka</h5>
		</div>
	</div>
	</div>

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
									echo "<th>Entreprenör</th>"; 
									echo "<th>Plats</th>"; 
									echo "</tr>";

									foreach ($pdo->query('
										SELECT *
										from SubPlaceViewer
										group by entID;
										')as $row) {

										$luck = $row ['entID'];
									echo "<tr>";
									echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
									echo "<td>";
									foreach($pdo->query( 'select realName from SubPlaceViewer where SubPlaceViewer.entID = '.$luck.' ORDER BY realName;' ) as $brow){;
										echo $brow['realName']."</br>";
									};
									echo "</td>";
									?>
								</tr>
								<?php
							}
							?> 
						</table><br><br>
					</div>
				</div>
			</div>
		</div>
		<div id="id02" class="w3-modal">
			<div class="w3-modal-content">
				<div class="w3-container">
					<span onclick="document.getElementById('id02').style.display='none'"
					class="w3-closebtn">&times;</span>
					<!-- Start av innehåll/Formen -->
					<div id="11" class="w3-container">
						
						<h3>Nollställ konstsnö på sträcka</h3>
						<form id="ZeroFakeSnow">
							<p>Delsträcka/Plats:
								<select name='Place'>    
									<?php 
									foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
										echo '<option value="'.$row['name'].'">';
										echo $row['realName'];
										echo "</option>";
									}
									?></select>
									<button type="button" onclick="SendForm('subplace', 'subplace', 'ZeroFakeSnow');">Nollställ</button></p></form>

									<h3>Alla delsträckor:</h3>
									<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
										<?php   
										echo "<tr>";
										echo "<th>Plats</th>"; 
										echo "<th>Konstsnö:</th>"; 
										echo "</tr>";

										foreach ($pdo->query('
											SELECT *
											from SubPlaceViewer;
											')as $row) {

											$luck = $row ['entID'];
										echo "<tr>";
										echo "<td>".$row['realName']."</td>";
										echo "<td>".$row['fakesnow']." m&#179</td>";
										echo "<tr>";
									}
									?> 
								</table><br><br>
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

			<?php
			if(isset($_POST['Place'])){
				$setZero = 0;
				$UpdateFSnow = $_POST['Place'];
				$sql = "UPDATE SubPlace SET fakesnow = $setZero WHERE name = $UpdateFSnow" ;
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
			}
			?>

