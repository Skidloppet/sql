<!DOCTYPE html>

<?php
include'../connect.php';
?>
<div class="w3-container" style="padding-left:31px">
<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:lightblue; border-style: solid; border-width: 5px;">
  <div class="w3-threethird">

    <h3>Utskrift av rapporter per sträcka:</h3>
       <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <?php   
        echo "<tr>";
          #echo "<th>sträcka:</th>"; 
          echo "<th>sträcka:</th>"; 
          #echo "<th>realName</th>"; 
          //echo "<th>newEntID</th>"; 
          echo "<th>Entreprenör:</th>"; 
          echo "<th>Rapporterad:</th>"; 
          echo "<th>Betyg:</th>"; 
          echo "<th>Underlag:</th>"; 
          echo "<th>Spårkanter:</th>"; 
          echo "<th>Stavfäste:</th>"; 
          echo "<th>Snödjup:</th>";
          echo "<th>Kommentar:</th>"; 
		  #echo "<th>report ID:</th>";
          echo "</tr>";

            foreach ($pdo->query('
                SELECT Reporting.name, Reporting.entID, Reporting.startDate, Reporting.workDate, Reporting.rating, Reporting.underlay, Reporting.edges, Reporting.grip, Reporting.depth, Reporting.comment, SubPlace.realName, Ent.firstName, Ent.lastName, Reporting.reportID
				        from overview, Reporting, SubPlace, Ent
				        WHERE Reporting.name = rspName AND Reporting.reportID = rspID AND Ent.entID = Reporting.entID AND SubPlace.name = Reporting.name
				        GROUP BY Reporting.reportID
                ORDER BY name asc;
              ')as $row) {
                $luck = $row['reportID'];
          echo "<tr>";
          #echo "<td>".$row['name']."</td>";
          #echo "<td>".$row['realName']."</td>";
          echo "<td>";
            foreach($pdo->query( 'select realName from SubPlace, Reporting where SubPlace.name = Reporting.name and Reporting.reportID = '.$luck.';' ) as $brow){;
            echo $brow['realName']."</br>";
          };
          echo "</td>";
          //echo "<td>".$row['entID']."</td>";
          echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
          echo "<td>".$row['startDate']."</td>";
          echo "<td>".$row['rating']."</td>";
          echo "<td>".$row['underlay']."</td>";
          echo "<td>".$row['edges']."</td>";
          echo "<td>".$row['grip']."</td>";
          echo "<td>".$row['depth']."</td>";
          echo "<td>".$row['comment']."</td>";
          #echo "<td>".$row['reportID']."</td>";
          echo "</tr>";  
          }
      ?>
    </table><br><br>
</div>
</div>
</div>

