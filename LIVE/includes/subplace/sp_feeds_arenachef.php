<!DOCTYPE html>

<?php
include'../connect.php';
?>


<div id="12" class="w3-container w3-blue">
  <h3>Alla av rapporter</h3>
  <table class="w3-table w3-striped w3-white">
    <?php   
    echo "<tr>";
    echo "<th>name</th>"; 
    echo "<th>placeName</th>"; 
    echo "<th>realName</th>"; 
    echo "<th>entID</th>"; 
    echo "<th>Entreprenör</th>"; 
    echo "<th>length</th>"; 
    echo "<th>height</th>"; 
    echo "<th>fakesnow</th>"; 
    echo "</tr>";

    foreach ($pdo->query('
      SELECT *
      from SubPlaceViewer;
      ')as $row) {

      echo "<tr>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['placeName']."</td>";
    echo "<td>".$row['realName']."</td>";
    echo "<td>".$row['entID']."</td>";
    echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
    echo "<td>".$row['length']."</td>";
    echo "<td>".$row['height']."</td>";
    echo "<td>".$row['fakesnow']."</td>";
    ?>
    <?php /*
    <td class="SubPlace-Update">
      <form target="_blank" action='<?php $_PHP_SELF ?>' method='POST'>
        <input type="hidden" name="UpdateSubPlaceEnt" value="<?php echo $row['name']; ?>">
        <input class="HoverButton" type="submit" name="updateSubEnt" value="Update">
      </form>
    </td>
    */
    ?>
    <?php
    echo "</tr>";  
  }
  ?>

<?php /*

      Div bredvid varje rad, tanken är att radens "name" skall sparas när diven skickar t.ex. tomas till pop-up-fönstret. I pop-uppen skall tomas kunna välja vilken entreprenör som skall vara ansvarig för utvald delsträcka. Problemet är att diven inte vill plocka upp delsträckan i fråga!

      Onclick längre ner hör till denna!

    <td input UpdateEnt" value="<?php echo $row['name']; ?>> 
      <div class="w3-third" style="cursor:pointer" onclick="document.getElementById('UpdateSubPlaceEnt').style.display='block'" >
        <div class="w3-container w3-green w3-padding-6">
          <div class="w3-right">
          </div>
          <div class="w3-clear"></div>
          <h10>Uppdatera entreprenör</h10>
        </div>
      </div>
    </td>
    <?php
    echo "</tr>";  
  }
  */
  ?>
</table>
</div>


<!--<div id="UpdateSubPlaceEnt" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('UpdateSubPlaceEnt').style.display='none'"
      class="w3-closebtn">&times;</span>
      <div class="w3-threethird"> -->
        <h5>Ändra ansvarig entreprenör för delsträcka: </h5>

        <p>Ny entreprenör för delsträcka <?php echo print_r($TargetSubPlace) ?></p>
        <select name='newEnt'>    
          <?php 
          foreach ($pdo->query('SELECT * FROM SubPlaceViewer') as $row) {
            echo '<option value="'.$row['entID'].'">';
            echo $row['firstName']; echo " "; echo $row['lastName'];
            echo "</option>";
          }
          ?></select>
          <?php
/* <td class="Report-delete">
            <form action='<?php $_PHP_SELF ?>' method='POST'>
              <input type="hidden" name="deleteReport" value="<?php echo $row['reportID']; ?>">
              <input class="HoverButton" type="submit" name="delReport" value="Delete">
            </form>
          </td> */

          if(isset($_POST['updateSubEnt'])){
            $querystring='UPDATE SubPlaceViewer SET
            entID = :newEnt
            WHERE
            name = :name';
            $stmt = $pdo->prepare($querystring);
            $stmt->bindParam(":newEnt", $_POST['newEnt'], PDO::PARAM_INT);
            $stmt->bindParam(":name", $TargetSubPlace, PDO::PARAM_INT);
            $stmt->execute();
          }
        ?>  
      </div>
    </div>
  </div></div>

<?php /* ?>
  <div id="11" class="w3-container w3-red">
    <h3>Ny Rapport</h3>
    <form action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method='POST' id="_newReport">

      <p>Delsträcka</p>
      <select name='place'>    
        <?php 
        foreach ($pdo->query('SELECT * FROM SubPlaceViewer') as $row) {
          echo '<option value="'.$row['name'].'">';
          echo $row['realName'];
          echo "</option>";
        }
        ?></select>

        <p>Ny entreprenör</p>
        <select name='newEnt'>    
          <?php 
          foreach ($pdo->query('SELECT * FROM SubPlaceViewer') as $row) {
            echo '<option value="'.$row['entID'].'">';
            echo $row['firstName']; echo " "; echo $row['lastName'];
            echo "</option>";
          }
          ?></select>
          <br><br>

          <textarea rows="5" cols="70" name="comment" placeholder="Kommentar..."></textarea>


          <p><button type="submit" name="_newReport">Ny rapport</button></p></form>
          <?php
          if(isset($_POST['storeReport'])){
            $querystring='UPDATE SubPlaceViewer SET(entID) VALUES (:reportID, :entID, :startDate, :workDate, :rating, :underlay, :edges, :grip, :depth, :comment, :name);';
            $stmt = $pdo->prepare($querystring);
            $stmt->bindParam(":reportID", $row['reportID'], PDO::PARAM_INT);
            $stmt->bindParam(":entID", $row['entID'], PDO::PARAM_INT);
            $stmt->bindParam(":startDate", $row['startDate'], PDO::PARAM_STR);
            $stmt->bindParam(":workDate", $row['workDate'], PDO::PARAM_STR);
            $stmt->bindParam(":rating", $row['rating'], PDO::PARAM_INT);
            $stmt->bindParam(":underlay", $row['underlay'], PDO::PARAM_INT);
            $stmt->bindParam(":edges", $row['edges'], PDO::PARAM_INT);
            $stmt->bindParam(":grip", $row['grip'], PDO::PARAM_INT);
            $stmt->bindParam(":depth", $row['depth'], PDO::PARAM_INT);
            $stmt->bindParam(":comment", $row['comment'], PDO::PARAM_STR);
            $stmt->bindParam(":name", $row['name'], PDO::PARAM_INT);
            $stmt->execute();
          }
          */
          ?>

          <!-- End page content -->
        </div>
      </div>
    </div>

    <script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
  if (mySidenav.style.display === 'block') {
    mySidenav.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidenav.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidenav with the close button
function w3_close() {
  mySidenav.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>
