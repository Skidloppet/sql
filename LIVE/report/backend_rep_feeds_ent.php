<!DOCTYPE html>

<?php
include'connect.php';
#include './backend_connect.php';
?>

<div class="w3-container">
  <h3>Ny Rapport</h3>
  <form action='<?php $_PHP_SELF ?>' method='POST'>
    <input type="text" name="WorkDate" placeholder="yyyy-mm-dd"></p>
    <input type="text" name="Depth" placeholder="Djup.."></p>

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


    <p><button type="submit" name="_newReport">Ny rapport</button></p></form>

  <?php

  if(isset($_POST['_newReport'])){

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
</div>

<div id="12" class="w3-container w3-blue">
    <h3>Utskrift av rapporter</h3>
    <table class="w3-table w3-striped w3-white">
      <?php   
        echo "<tr>";
          echo "<th>reportID</th>"; 
          echo "<th>newEntID</th>"; 
          echo "<th>newStartDate</th>"; 
          echo "<th>newWorkDate</th>"; 
          echo "<th>newRating</th>"; 
          echo "<th>newUnderlay</th>"; 
          echo "<th>newEdges</th>"; 
          echo "<th>newGrip</th>"; 
          echo "<th>newDepth</th>";
          echo "<th>kommentar</th>";
          echo "<th>sträcka</th>";  
          echo "</tr>";

        foreach($pdo->query( 'SELECT * FROM Reporting;' ) as $row){
          //echo "<tr><td>";
          //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
          echo "<tr>";
          echo "<td>".$row['reportID']."</td>";
          echo "<td>".$row['entID']."</td>";
          echo "<td>".$row['startDate']."</td>";
          echo "<td>".$row['workDate']."</td>";
          echo "<td>".$row['rating']."</td>";
          echo "<td>".$row['underlay']."</td>";
          echo "<td>".$row['edges']."</td>";
          echo "<td>".$row['grip']."</td>";
          echo "<td>".$row['depth']."</td>";
          echo "<td>".$row['comment']."</td>";
          echo "<td>".$row['name']."</td>";
          echo "</tr>";  
          }
      ?>
    </table>
</div>
 <!-- 
<div class="w3-container w3-dark-grey w3-padding-32">
  <div class="w3-row">
    <div class="w3-container w3-third">
      <h5 class="w3-bottombar w3-border-green">Demographic</h5>
      <p>Language</p>
      <p>Country</p>
      <p>City</p>
    </div>
    <div class="w3-container w3-third">
      <h5 class="w3-bottombar w3-border-red">System</h5>
      <p>Browser</p>
      <p>OS</p>
      <p>More</p>
    </div>
    <div class="w3-container w3-third">
      <h5 class="w3-bottombar w3-border-orange">Target</h5>
      <p>Users</p>
      <p>Active</p>
      <p>Geo</p>
      <p>Interests</p>
    </div>
  </div>
</div>
-->
<!-- Footer -->
<footer class="w3-container w3-padding-16 w3-light-grey">
  <!-- <h4>FOOTER</h4> -->
  <p>Powered by <a href="http://www.his.se" target="_blank">SLITAB</a></p>
</footer>

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
