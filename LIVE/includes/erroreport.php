

    <!-- Header -->
    <?php
   include 'errorreport/err_headerbox.php';
    ?>

    <div class="w3-container w3-section">
      <div class="w3-row-padding" style="margin:0 -16px">

        <div class="w3-threethird">
          <?php
          //include './backend_feeds.php';
          ?>
        </div>
        <hr>

<!--
Ny felanmälan.
Kan vara värt att visa namn istället för ID på entreprenör?
Ändra name till realname (sträcka)
Fortsätta använda border på tabell? annars ser det ut som om all text står i en mening.
Göra om så att start / slut är listbox med realname?
-->

<?php
include'connect.php';

?>


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
