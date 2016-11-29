<!DOCTYPE html>
<?php
include'../connect.php';
?>
<br><br>
<div id="12" class="w3-container w3-blue">
    <h3>Utskrift av registrerade felanmälningar</h3>
    <table class="w3-table w3-striped w3-white">
      <?php  
            echo "<tr>";
            #echo "<th style='background-color:white;'>Sträcka:</th>";
            echo "<th style='background-color:white;'>Sträcka:</th>"; 
            #echo "<th style='background-color:white;'>entID:</th>";
            echo "<th style='background-color:white;'>Entreprenör:</th>";
            echo "<th style='background-color:white;'>Skickad:</th>";
            echo "<th style='background-color:white;'>Beskrivning:</th>";
            echo "<th style='background-color:white;'>Typ:</th>";
            echo "<th style='background-color:white;'>Errorid:</th>";
            echo "</tr>";

          foreach($pdo->query( 'SELECT * 
            FROM Error, ErrorSubPlace, Ent, SubPlace
            WHERE Error.errorID = ErrorSubPlace.errorID AND Ent.entID = Error.entID and SubPlace.name = ErrorSubPlace.name;
            ' ) as $row){
            echo "<tr>";
            #echo "<td>".$row['name']."</td>";
            echo "<td>".$row['realName']."</td>";
            #echo "<td>".$row['entID']."</td>";
            echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
            echo "<td>".$row['sentDate']."</td>";
            echo "<td>".$row['errorDesc']."</td>";
            echo "<td>".$row['type']."</td>";
            echo "<td>".$row['errorID']."</td>";
            ?>
            <td class="Error-delete">
            <form action='<?php $_PHP_SELF ?>' method='POST'>
              <input type="hidden" name="deleteError" value="<?php echo $row['errorID']; ?>">
              <input class="HoverButton" type="submit" name="delError" value="Delete">
            </form>
          </td>
          <?php
            echo "</tr>";  
        }
      ?>
    </table>
    <br><br>
</div>

<?php
  if(isset($_POST['delError'])){
  $deletedError = $_POST['deleteError'];
  $sql = "DELETE FROM Error WHERE ErrorID = $deletedError" ;
  $sql = "DELETE FROM ErrorSubPlace WHERE errorId = $deletedError" ;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
    }
?>

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
