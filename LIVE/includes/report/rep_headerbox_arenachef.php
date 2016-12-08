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

<div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id12').style.display='block'">
  <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-teal w3-padding-16">
    <div class="w3-left"><i class="fa fa-repeat w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3></br></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Rapporter (<i> max 20 </i>)</h4>
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



  <!-- Popup till SKAPA RAPPORT -->

  <div id="id12" class="w3-modal ">   
    <div class="w3-modal-content " style="width:1480px">     
      <div class="w3-container ">       
        <span onclick="document.getElementById('id12').style.display='none'"
        class="w3-closebtn">&times;
      </span>

      <div class="w3-container">

        <h3>De 20 senaste rapporterna:</h3>
        <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
          <?php   
          echo "<tr>";
          echo "<th><u>Delsträckor:</u></th>"; 
          echo "<th>Rapporterad:</th>"; 
          echo "<th>Kommentar:</th>";  
          echo "<th>Entreprenör:</th>"; 
          echo "<th>Nästa planerade arbetspass:</th>"; 
          echo "<th>Betyg:</th>"; 
          echo "<th>Underlag:</th>"; 
          echo "<th>Spårkanter:</th>"; 
          echo "<th>Stavfäste:</th>"; 
          echo "<th>Snödjup:</th>";
      #echo "<th>report ID:</th>";
          echo "</tr>";

          foreach ($pdo->query('Select * From Reporting, Ent WHERE Reporting.entID = Ent.entID group by reportID order by startDate desc limit 20;')as $row) {
          $luck = $row['reportID'];
            echo "<tr>";
        echo "<td>";
        foreach($pdo->query( 'select realName from SubPlace, Reporting where SubPlace.name = Reporting.name and Reporting.reportID = '.$luck.';' ) as $brow){;
          echo $brow['realName']."</br>";
        };
        echo "</td>";
          echo "<td>".$row['startDate']."</td>";
          echo "<td>".$row['comment']."</td>";
          echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
          echo "<td>".$row['workDate']."</td>";
          echo "<td>".$row['rating']."</td>";
          echo "<td>".$row['underlay']."</td>";
          echo "<td>".$row['edges']."</td>";
          echo "<td>".$row['grip']."</td>";
          echo "<td>".$row['depth']."</td>";
          #echo "<td>".$row['reportID']."</td>";
          echo "</tr>";  
        }
        ?>
      </table><br><br>
    </div>
  </div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>




</div>