<!DOCTYPE html>
<?php
include'../connect.php';
?>


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
            echo "</tr>";  
        }
      ?>
    </table>
    <br><br>
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
