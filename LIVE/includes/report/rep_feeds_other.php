<!DOCTYPE html>

<?php
include'../connect.php';
?>


<div id="12" class="w3-container w3-blue">
    <h3>Utskrift av rapporter</h3>
    <table class="w3-table w3-striped w3-white">
      <?php   
        echo "<tr>";
          echo "<th>sträcka</th>"; 
          echo "<th>realName</th>"; 
          echo "<th>reportID</th>"; 
          //echo "<th>newEntID</th>"; 
          echo "<th>EntName</th>"; 
          echo "<th>newStartDate</th>"; 
          echo "<th>newWorkDate</th>"; 
          echo "<th>newRating</th>"; 
          echo "<th>newUnderlay</th>"; 
          echo "<th>newEdges</th>"; 
          echo "<th>newGrip</th>"; 
          echo "<th>newDepth</th>";
          echo "<th>kommentar</th>"; 
          echo "</tr>";

            foreach ($pdo->query('
                SELECT Reporting.name, Reporting.entID, Reporting.startDate, Reporting.workDate, Reporting.rating, Reporting.underlay, Reporting.edges, Reporting.grip, Reporting.depth, Reporting.comment, SubPlace.realName, Ent.firstName, Ent.lastName, Reporting.reportID
                from overview, Reporting, SubPlace, Ent
                WHERE Reporting.name = rspName AND Reporting.reportID = rspID AND Ent.entID = Reporting.entID AND SubPlace.name = Reporting.name
                GROUP BY Reporting.name;
              ')as $row) {
                
          echo "<tr>";
          echo "<td>".$row['name']."</td>";
          echo "<td>".$row['realName']."</td>";
          echo "<td>".$row['reportID']."</td>";
          //echo "<td>".$row['entID']."</td>";
          echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
          echo "<td>".$row['startDate']."</td>";
          echo "<td>".$row['workDate']."</td>";
          echo "<td>".$row['rating']."</td>";
          echo "<td>".$row['underlay']."</td>";
          echo "<td>".$row['edges']."</td>";
          echo "<td>".$row['grip']."</td>";
          echo "<td>".$row['depth']."</td>";
          echo "<td>".$row['comment']."</td>";
          ?>
        <?php
          echo "</tr>";  
          }
      ?>
    </table><br><br>
</div>

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


<!-- End page content -->
</div>
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
