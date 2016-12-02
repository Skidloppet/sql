
<?php
include '../connect.php';	
?>	

<div class="w3-row-padding" style="border-color:lightblue; border-style: solid; border-width: 5px;">
  <div class="w3-threethird">
    <h5></h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <tr>
        <th><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i>id</th>
        <th>Namn (id)</th>
        <th>Nuvarande plats (Konstsnö m3)</th>
        <th>Status</th>
        <th>Effekt</th>
        <th>Senast ändrad</th>
      </tr>        
      <?php     

      foreach($pdo->query( 'SELECT * FROM canT order by cannonID desc;' ) as $row){
        echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
        echo "<td>".$row['klass']." ( ".$row['cannonID']." ) </td>";
/*        echo "<td>";
        foreach($pdo->query( 'select realName from SubPlace, SubPlaceWorkOrder where SubPlace.name = SubPlaceWorkOrder.name and SubPlaceWorkOrder.orderID = '.$row ['orderID'].';' ) as $brow){;
          echo $brow['realName']"</br>";
              }
              echo "</td>"; */
              echo "<td>".$row['firstName']." ".$row['lastName']." ( ".$row['entID']." )</td>";
              echo "<td>".$row['realName']." ( ".$row['fakesnow']."m&#179</td>";
              echo "<td>".$row['priority']."</td>";
              echo "<td>".$row['entF']." ".$row['entL']."</td>";
              echo "<td>".$row['info']."</td>";
              echo "<td>".$row['sentDate']."</td>";
              echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
              echo "<td>";

              CannonSubPlace.cannonID as CcannonID, name,skiID,entID, startStamp, endStamp, priority, newStatus, info,
              Cannon.cannonID as SCannonID, subPlaceName, model, state, effect, klass
              from Cannon, CannonSubPlace;


              ?>
              <form action='<?php echo $_SERVER['SCRIPT_NAME']; ?>' method='POST'>
                <input type="hidden" name="orderID" value="<?php echo $row['orderID']; ?>">
                <button class="fa fa-ban HoverButton" type="submit" name="bort"> Radera</button>
              </form>  
            </td>
            <td>
              <form action='<?php echo $_SERVER['SCRIPT_NAME']; ?>' method='POST'>
                <input type="hidden" name="orderID" value="<?php echo $row['orderID']; ?>">
                <button class="fa fa-check HoverButton" type="submit" name="lagra"> Klarmarkera</button>
              </form>
            </td>
          </tr>
          <?php
        }
        ?>   
      </table>
    </div>
  </div>



  <?php
  if(isset($_POST['btn_save'])) 
   {   $fruitArray = array('orange', 'apple', 'grapefruit', 'banana', 'watermelon'); 
 If(isset($_POST['fruit'])) 
       {   $values = array(); // store the selection 
         foreach($_POST['fruit'] as $selection )
           {   if(in_array($selection, $fruitArray)) 
             { $values[ $selection ] = 1; } 
             else 
               { $values[ $selection ] = 0; } 
           }
         }
       }
       ?>

<!-- 

<div class="w3-container w3-third w3-margin w3-section w3-right">


-->