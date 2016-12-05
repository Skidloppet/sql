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
 <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-teal w3-padding-16">
    <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><br></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Skapa ny rapport</h4>
  </div>
</div>

<a href="#12">
  <div class="w3-third">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-teal w3-padding-16">
      <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3><?php print_r($i); ?></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Senaste rapport per sträcka</h4>
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
        <h3>Ny Rapport</h3>
        <form id="IDRep">
          <p>Nästa planerade arbetspass  <i>( förhandsval +1 dygn )</i></p>
          <input type="text" name="WorkDate" value="<?php echo date("Y-m-d G:i", strtotime("+1 day")); ?>"></br>
                    <p>Snödjup: <i>(cm)</i></p>
          <input type="text" name="Depth" placeholder="ex 102.5"></p>

          <p>Helhetsbetyg:</p>
          <select name="Rating">
            <?php
            $sql = 'SHOW COLUMNS FROM Report WHERE field="rating"';
            $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
              print("<option>$option</option>");
            }
            ?>
          </select>

          <p>Underlag:</p>
          <select name="Underlay">
            <?php
            $sql = 'SHOW COLUMNS FROM Report WHERE field="underlay"';
            $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
              print("<option>$option</option>");
            }
            ?>
          </select>

          <p>Spårkanter:</p>
          <select name="Edges">
            <?php
            $sql = 'SHOW COLUMNS FROM Report WHERE field="edges"';
            $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
              print("<option>$option</option>");
            }
            ?>
          </select>

          <p>Stavfäste:</p>
          <select name="Grip">
            <?php
            $sql = 'SHOW COLUMNS FROM Report WHERE field="grip"';
            $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
              print("<option>$option</option>");
            }
            ?>
          </select>

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
            <select name='Slut'>    
              <?php 
              foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
                echo '<option value="'.$row['name'].'">';
                echo $row['realName'];
                echo "</option>";
              }
              ?></select><br><br>

              <textarea rows="5" cols="70" name="comment" placeholder="Kommentar..."></textarea>
              <br><br>

              <button type="button" onclick="SendForm('report', 'report', 'IDRep');">Ny rapport</button></form>

              <?php

              if(isset($_POST['comment'])){

                $sql = "CALL _newReport(:newEntID, now(), :newWorkDate, :newRating, :newUnderlay, :newEdges, :newGrip, :newDepth, :newComment, :startName, :endName)";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":newEntID", $_SESSION['id'], PDO::PARAM_INT);
    //$stmt->bindParam(":newStartDate", $_POST['StartDate'], PDO::PARAM_STR);
                $stmt->bindParam(":newWorkDate", $_POST['WorkDate'], PDO::PARAM_STR);
                $stmt->bindParam(":newRating", $_POST['Rating'], PDO::PARAM_INT);
                $stmt->bindParam(":newUnderlay", $_POST['Underlay'], PDO::PARAM_INT);
                $stmt->bindParam(":newEdges", $_POST['Edges'], PDO::PARAM_INT);
                $stmt->bindParam(":newGrip", $_POST['Grip'], PDO::PARAM_INT);
                $stmt->bindParam(":newDepth", $_POST['Depth'], PDO::PARAM_INT);
                $stmt->bindParam(":newComment", $_POST['comment'], PDO::PARAM_STR);
                $stmt->bindParam(":startName", $_POST['Start'], PDO::PARAM_INT);
                $stmt->bindParam(":endName", $_POST['Slut'], PDO::PARAM_INT);
                $stmt->execute();
              }

              ?>
              <br><br><br><br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>