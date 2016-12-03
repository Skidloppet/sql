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

<!-- Popup till SKAPA RAPPORT -->

<div id="id01" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id01').style.display='none'"
      class="w3-closebtn">&times;</span>
      <!-- Start av innehåll/Formen -->
      <div id="11" class="w3-container">

      <h3>Ny ansvarig</h3>
      <form id="ChangeSubEnt">

        <p>Start</p>
        <select name='Start'>    
          <?php 
          foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
            echo '<option value="'.$row['name'].'">';
            echo $row['realName'];
            echo "</option>";
          }
          ?></select>

          <p>Slut</p>
          <select name='Ent'>    
            <?php 
            foreach ($pdo->query('SELECT * FROM Ent') as $row) {
              echo '<option value="'.$row['entID'].'">';
              echo $row['firstName']." ".$row['lastName'];
              echo "</option>";
            }
            ?> 
          </select><br><br>
          <button type="button" onclick="SendForm('subplace', 'subplace', 'ChangeSubEnt');">Ny ansvarig</button></form>

          <br><br><br><br>
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