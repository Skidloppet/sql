<!DOCTYPE html>
<?php
include'../connect.php';
?>

<div class="w3-container" style="padding-left:31px">
<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:lightblue; border-style: solid; border-width: 5px;">
<div class="w3-threethird">
      <h3>Utskrift av registrerade felanmälningar</h3>
      <p>Senaste rapporterade felanmälningar överst i tabell.</p>
      <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <?php  
        echo "<tr>";
        echo "<th style='background-color:white;'>Sträcka:</th>"; 
        echo "<th style='background-color:white;'>Entreprenör som har felanmält:</th>";
        echo "<th style='background-color:white;'>Beskrivning:</th>";
        echo "<th style='background-color:white;'>Skickad:</th>";
        echo "<th style='background-color:white;'>Typ:</th>";
        echo "<th style='background-color:white;'>Error ID:</th>";
        echo "</tr>";

        foreach($pdo->query( 'SELECT ErrorSubPlace.name, Error.entID, SubPlace.realName, Ent.firstName, Ent.lastName, Error.errorID, Error.errorDesc, Error.sentDate, Error.type
          FROM Error, ErrorSubPlace, Ent, SubPlace
          WHERE Error.errorID = ErrorSubPlace.errorID AND Ent.entID = Error.entID and SubPlace.name = ErrorSubPlace.name 
          GROUP BY Error.errorID
          ORDER BY Error.errorID desc;
          ' ) as $row){

          $luck = $row['errorID'];
          echo "<tr>";
        echo "<td>";
        foreach($pdo->query( 'select realName from SubPlace, ErrorSubPlace where ErrorSubPlace.name = SubPlace.name and ErrorSubPlace.errorID = '.$luck.';' ) as $brow){;
          echo $brow['realName']."</br>";
        };
        echo "</td>";

        echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
        echo "<td>".$row['errorDesc']."</td>";
        echo "<td>".$row['sentDate']."</td>";
        echo "<td>".$row['type']."</td>";
        echo "<td>".$row['errorID']."</td>";
        ?>
     </tr>
     <?php
   }
   ?>

 </table>
 <br><br>
</div>
</div>
</div>
