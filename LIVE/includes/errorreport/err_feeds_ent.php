<!DOCTYPE html>
<?php
include'../connect.php';
?>


<div id="11" class="w3-container w3-red">
    <h3>Utskrift av registrerade felanmälningar</h3>
  <h3>Ny felanmälan!</h3>
  <form action='backend_ErrorReport.php' method='POST'>
    <textarea rows="5" cols="70" name="desc" placeholder="Beskriv problemet..."></textarea>
    </br>

    <p>Ange problemets typ:</p>
    <select name='type'>
      <option selected="selected"> Sätt typ</option>
      <option value="lights">Ljus - Lyktstolpar, liknande</option>
      <option value="tracks">Bana - Problem med banan</option>
      <option value="dirt">Smuts - Skräp, kottar</option>
      <option value="trees">Träd - Som påverkar banan</option>
      <option value="other">Annat</option>
    </select>
    <br>

    <!-- Listbox till att välja startsträcka-->
    <p>Vart startade problemet?:</p>
    <select name='Start'>    
      <?php 
      foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
        echo '<option value="'.$row['name'].'">';
        echo $row['realName'];
        echo "</option>";
      }
    ?>
    </select><br>

    <!-- Listbox till att välja slutsträcka-->
    <p>Vart slutar problemets inverkan?:</p>
        <select name='Slut'>    
      <?php 
      foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
        echo '<option value="'.$row['name'].'">';
        echo $row['realName'];
        echo "</option>";
      }
    ?>
    </select><br><br>

    <p><button type="submit" name="Error">Ny felanmälan</button></p></form>


  <?php
  if(isset($_POST['Error'])){

    $sql = "CALL _NewError(:newErrorDesc, :newEntID, NOW() , :newType, :startName, :endName);";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":newErrorDesc", $_POST['desc'], PDO::PARAM_STR);
    $stmt->bindParam(":newEntID", $_SESSION['id'], PDO::PARAM_INT);
    //$stmt->bindParam(":newGrade", $_POST['grade'], PDO::PARAM_STR);
    $stmt->bindParam(":newType", $_POST['type'], PDO::PARAM_STR);
    $stmt->bindParam(":startName", $_POST['Start'], PDO::PARAM_INT);
    $stmt->bindParam(":endName", $_POST['Slut'], PDO::PARAM_INT);
    $stmt->execute();
}    
?>
</div>


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
            echo "<th style='background-color:white;'>Error ID:</th>";
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
