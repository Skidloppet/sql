<!DOCTYPE html>

<?php
include'../connect.php';
?>


<div id="12" class="w3-container w3-blue">
    <h3>Alla av rapporter</h3>
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
          ?>
          <td class="Report-delete">
            <form action='<?php $_PHP_SELF ?>' method='POST'>
              <input type="hidden" name="deleteReport" value="<?php echo $row['reportID']; ?>">
              <input class="HoverButton" type="submit" name="delReport" value="Delete">
            </form>
          </td>

          <td class="Report-Store">
            <form action='backend_report.php?reportID="<?php echo $Report['reportID']; ?>"' method='POST'>
              <input type="hidden" name="storeReport" value="<?php $row['reportID']; ?>">
              <input class="HoverButton2" type="submit" name="storeReport" value="Store">
            </form>
          </td>
        <?php
          echo "</tr>";  
          }
      ?>
    </table><br><br>
</div>
<?php
  if(isset($_POST['delReport'])){
  $deletedReport = $_POST['deleteReport'];
  $sql = "DELETE FROM Report WHERE reportID = $deletedReport" ;
  $sql = "DELETE FROM ReportSubPlace WHERE reportID = $deletedReport" ;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
    }
?>
<?php
if(isset($_POST['storeReport'])){
  $querystring='INSERT INTO StoredReports (reportID, entID, startDate, workDate, rating, underlay, edges, grip, depth, comment, name) VALUES (:reportID, :entID, :startDate, :workDate, :rating, :underlay, :edges, :grip, :depth, :comment, :name);';
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
?>
<div id="13" class="w3-container w3-green">
    <h3>Utskrift av sparade rapporter</h3>
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
        foreach($pdo->query( 'SELECT * FROM StoredReports;' ) as $row){
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
}
?>
</table>
<br><br>
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
