
<?php
include '../connect.php';	
?>	

<?php
if(isset($_POST['bort'])){
 $orderID = $_POST['orderID'];
 $querystring='DELETE FROM WorkOrder WHERE orderID = :orderID';
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':orderID', $_POST['orderID'], PDO::PARAM_INT);
 $stmt->execute();
 echo "Arbetsorder borttagen";
}
?>
<?php
if(isset($_POST['lagra'])){
 $orderID = $_POST['orderID'];
 $querystring='CALL _finnishedWorkOrder(:orderID,'.$id.',NOW(),"logged by: '.$em.'")';
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':orderID', $_POST['orderID'],PDO::PARAM_INT);
 $stmt->execute();
 echo "Arbetsorder arkiverad";
}
?>
<?php
if(isset($_POST['newEnt'])){
  $entID = $_POST['entID'];
  $orderID = $_POST['orderID'];
  $sql = "call _newResponsability (:_entID,:_orderID)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":_entID", $_POST['entID'], PDO::PARAM_INT);
  $stmt->bindParam(":_orderID", $_POST['orderID'], PDO::PARAM_INT);
  $stmt->execute();
}    
?>

<?php
$akut = 0;
foreach($pdo->query( 'SELECT count(*) as nmr FROM wo where priority="akut" and entID="1";' ) as $row){
  $akut = $row['nmr'];
  if (0 < $akut){
    ?>
    <div class="w3-container w3-orange" style="border-color:lightblue; border-style: solid; border-width: 5px;">
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <h1 style="color:red;">Akuta arbetsordrar</h1>
            <table class="w3-table w3-striped w3-white">
              <tr>
                <td><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></td>
                <th>Order ID</th>
                <th>Arbetsorder-Typ</th>
                <th>Prioritet</th>
                <th>Information</th>
                <th>Datum skickad</th>
                <th>Skapad av</th>
                <th>Ange entrepenör</th>
              </tr> 

              <?php     
        # hämtar alla aktiva arbetsordrar(WorkOrder) som tillhör det autoangivna akutID (#1)
        # hemsidan visar entrepenörens förnamn och enfternamn genom kopplingen mellan

              foreach($pdo->query( 'SELECT * FROM wo where priority="akut" and entID="1" order by orderID desc;' ) as $row){
               echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
               echo "<td>".$row['orderID']."</td>";
               echo "<td>".$row['type']."</td>";
               echo "<td>".$row['priority']."</td>";
               echo "<td>".$row['info']."</td>";
               echo "<td>".$row['sentDate']."</td>";
               echo "<td>".$row['entF']." ".$row['entL']." ( ".$row['entID']." )</td>";
               ?>
               <td>
                <form action='<?php echo $_SERVER['SCRIPT_NAME']; ?>' method='POST'>
                  <input type="hidden" name="orderID" value="<?php echo $row['orderID']; ?>">
                  <select name='entID'>    
                    <?php 
              # i varje rad av svar den skriver ut så skapas en lista med alla Ent förnamn&efternamn
              # sätter value till entrepenöresns ID 
                    foreach ($pdo->query('SELECT * FROM Ent') as $row) {
                      echo '<option value="'.$row['entID'].'">';
                      echo $row['firstName']." ".$row['lastName'];
                      echo "</option>";
                    }
                    ?>
                  </select>
                  <input class="HoverButton" type="submit" name="newEnt">
                </form>
              </td>
              <?php
              echo "</td></tr>";  
            }
            ?>   
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php
}
}
?>

<h2>Översikt</h2>

<div  class="w3-threethird" style="border-color:lightblue; border-style: solid; border-width: 5px;">
  <?php
  include './map.php';
  ?>
</div>
</div>
</div>
</div>
</div>

<div class="w3-row-padding" style="border-color:lightblue; border-style: solid; border-width: 5px;">
  <div class="w3-threethird">
    <h5>Pågående arbetsordrar</h5>
    <table class="w3-table w3-striped w3-white">
      <tr>
        <th><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></th>
        <th>Order ID</th>
        <th>Område(n)</th>
        <th>Arbetsorder-Typ</th>
        <th>Prioritet</th>
        <th>Ansvarig</th>
        <th>Information</th>
        <th>Datum skickad</th>
        <th>Skapad av</th>
        <th>Ta bort</th>
        <th>Arkivera</th>
      </tr>        
      <?php     

      foreach($pdo->query( 'SELECT * FROM wo order by orderID desc;' ) as $row){
        $luck = $row ['orderID'];
        echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
        echo "<td>".$row['orderID']."</td>";
        echo "<td>";
        foreach($pdo->query( 'select realName from SubPlace, SubPlaceWorkOrder where SubPlace.name = SubPlaceWorkOrder.name and SubPlaceWorkOrder.orderID = '.$luck.';' ) as $brow){;
          echo $brow['realName']."</br>";
        };
        echo "</td>";
        echo "<td>".$row['type']."</td>";
        echo "<td>".$row['priority']."</td>";
        echo "<td>".$row['entF']." ".$row['entL']."</td>";
        echo "<td>".$row['info']."</td>";
        echo "<td>".$row['sentDate']."</td>";
        echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
        echo "<td>";
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


<div class="w3-row-padding" style="border-color:lightblue; border-style: solid; border-width: 5px; margin-top:15px;">
  <div class="w3-threethird">
    <h5>Senaste avklarade rapporterna (max 5)</h5>
    <table class="w3-table w3-striped w3-white">
      <tr>
        <th><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></th>
        <th>Report-ID</th>
        <th>Spårade delsträckor</th>
        <th>Entrepenör</th>
        <th>Avklarad</th>
        <th>Nästa planerade pass</th>
        <th>Betyg</th>
        <th>Underlag</th>
        <th>Spårkanter</th>
        <th>Stavfäste</th>
        <th>Snödjup</th>
        <th>Kommentar</th>
      </tr>        
      <?php     

      foreach($pdo->query( 'select * from storedR;' ) as $row){
        $luck = $row ['reportID'];
        echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
        echo "<td>".$row['reportID']."</td>";
        echo "<td>";
        foreach($pdo->query( 'select realName from SubPlace, ReportSubPlace where SubPlace.name = ReportSubPlace.name and ReportSubPlace.reportID = '.$luck.';' ) as $brow){;
          echo $brow['realName']."</br>";
        };
        echo "</td>";        echo "<td>".$row['firstName']." ".$row['lastName']." ( ".$row['entID']." )</td>";
        echo "<td>".$row['startDate']."</td>";
        echo "<td>".$row['workDate']."</td>";
        echo "<td>".$row['rating']."</td>";
        echo "<td>".$row['underlay']."</td>";
        echo "<td>".$row['edges']."</td>";
        echo "<td>".$row['grip']."</td>";
        echo "<td>".$row['depth']."</td>";
        echo "<td>".$row['comment']."</td>";
        echo "</tr>";  
      }
      ?>   
    </table>
  </div>

</div>

