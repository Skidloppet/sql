<!DOCTYPE html>
<!--
Kommentarer:
stängde 2 div taggar som var öppna

-->

<!--
Ny felanmälan.
Kan vara värt att visa namn istället för ID på entreprenör?
Ändra name till realname (sträcka)
Fortsätta använda border på tabell? annars ser det ut som om all text står i en mening.
Göra om så att start / slut är listbox med realname?
-->

<?php
include'connect.php';
#include './backend_connect.php';
?>


<div class="w3-container">
  <h3>Ny felanmälan!</h3>
  <form action='backend_ErrorReport.php' method='POST'>
    <textarea rows="5" cols="70" name="desc" placeholder="Beskriv problemet..."></textarea>
    </br>
    <!--<p>Ange graden av problemets påverkan</p>-->

    <!--<select name='grade'>
      <option selected="selected"> Sätt nivå</option>
      <option value="low">Lågt - Påverkar knappt</option>
      <option value="medium">Medium - Påverkar en del</option>
      <option value="high">Hög - Påverkar mycket</option>
      <option value="akut">Akut - Grovt problem</option>
    </select>
    <br><br> -->
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


    <!--<input type="text" name="type" placeholder="type.."></p>-->


    <!-- Ändra till session! (Entreprenör) -->
    <!--<p>Ange ansvarig entreprenörs id, ex: 1:</p>
    <input type="text" name="entID" placeholder="entID.."></p>
    -->

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


    <!--<input type="text" name="Start" placeholder="Start.."></p>-->


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

    <!--<input type="text" name="Slut" placeholder="Slut.."></p>-->


    <p><button type="submit" name="Error">Ny felanmälan</button></p></form>


  <?php
#  $em = $_SESSION['email'];

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


<div class="w3-container">
  <h3>Utskrift av registrerade felanmälningar</h3>
    <table border="1">
      <?php  
            echo "<tr>";
            echo "<th style='background-color:white;'>Errorid:</th>"; 
            echo "<th style='background-color:white;'>Entreprenör:</th>";
            echo "<th style='background-color:white;'>Skickad:</th>";
            echo "<th style='background-color:white;'>Beskrivning:</th>";
            echo "<th style='background-color:white;'>Typ:</th>";
            echo "<th style='background-color:white;'>Sträcka:</th>";
            echo "</tr>";

          foreach($pdo->query( 'SELECT * FROM Error, ErrorSubPlace WHERE Error.errorID = ErrorSubPlace.errorID;' ) as $row){
            echo "<tr>";
            echo "<td>".$row['errorID']."</td>";
            echo "<td>".$row['entID']."</td>";
            echo "<td>".$row['sentDate']."</td>";
            echo "<td>".$row['errorDesc']."</td>";
            echo "<td>".$row['type']."</td>";
            echo "<td>".$row['name']."</td>";

            echo "</tr>";  
        }
      ?>
    </table>
</div>

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
