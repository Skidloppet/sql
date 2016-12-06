
<?php
include '../connect.php';	
?>	

<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:lightblue; border-style: solid; border-width: 5px;">
  <div class="w3-threethird">
    <h3>Snökanoner</h3>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <tr>
        
        <th>Modell (id)</th>
        <th>Position</th>
        <th>Status</th>
        <th>Effekt m&#179/min</th>
      </tr>        
      <?php     

      foreach($pdo->query( 'SELECT * FROM ca order by cannonID desc;' ) as $row){
        echo "<td>".$row['klass']." (<b> ".$row['cannonID']."</b> ) </td>";
/*        echo "<td>";
        foreach($pdo->query( 'select realName from SubPlace, SubPlaceWorkOrder where SubPlace.name = SubPlaceWorkOrder.name and SubPlaceWorkOrder.orderID = '.$row ['orderID'].';' ) as $brow){;
          echo $brow['realName']"</br>";
              }
              echo "</td>"; */
              echo "<td>".$row['subPlaceName']."</td>";
              echo "<td>".$row['state']."</td>";
              echo "<td>".$row['effect']."</td>";
              echo "</tr>";
            }
            ?>
          </table>
        </div>
      </div>

