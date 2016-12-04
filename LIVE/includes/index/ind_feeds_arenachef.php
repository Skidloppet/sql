
<?php
include '../connect.php';	
?>	

<?php
if(isset($_POST['orderID1'])){
 $querystring='DELETE FROM delWO WHERE orderID = :orderID';
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':orderID', $_POST['orderID1'], PDO::PARAM_INT);
 $stmt->execute();
 echo "Arbetsorder borttagen";
}
?>
<?php
if(isset($_POST['orderID2'])){
 $querystring='CALL _finnishedWorkOrder(:orderID,'.$id.',NOW(),"logged by: '.$em.'")';
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':orderID', $_POST['orderID2'],PDO::PARAM_INT);
 $stmt->execute();
 echo "Arbetsorder arkiverad";
}
?>

<?php

if(isset($_POST['orderID3'])){
  $sql = "call _newResponsability (:_entID,:_orderID)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":_entID", $_POST['entID'], PDO::PARAM_INT);
  $stmt->bindParam(":_orderID", $_POST['orderID3'], PDO::PARAM_INT);
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
            <h1>Akuta arbetsordrar</h1>
            <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
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
                <form id="SetEnt<?php echo $row['orderID']; ?>">
                  <input type="hidden" name="orderID3" value="<?php echo $row['orderID']; ?>">
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
                  <button type="button" onclick="SendForm('index','index','SetEnt<?php echo $row['orderID']; ?>');" class="HoverButton" >radd</button>
                </form>

              </td>
            </tr>

              <?php
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
   <h5>Snittbetygen på hela arenan</h5>
   <?php

   foreach($pdo->query( 'SELECT * FROM snittBetyg, snitt;' ) as $row){

      # kolla VIEW snittBetyg & snitt
      # lade till B tagg för att göra snittet enklare att se (row r,u,e,g /5)

    echo '<p>Helhetsbetyg</p>';
    echo '<div class="w3-progress-container w3-grey">';

    echo '<div id="myBar" class="w3-progressbar w3-blue" style="width:'.$row["rat"].'%">';
    echo '<div class="w3-center w3-text-white"><b>'.$row["r"].'/5</b></div>';
    echo 'echo   </div>';
    echo ' </div>';
    echo '   <p>Underlag</p>';
    echo ' <div class="w3-progress-container w3-grey">';

    echo '  <div id="myBar" class="w3-progressbar w3-red" style="width:'.$row["under"].'%">';
    echo '   <div class="w3-center w3-text-white"><b>'.$row["u"].'/5</b></div>';
    echo '   </div>';
    echo ' </div>';

    echo '  <p>Spårkanter</p>';
    echo ' <div class="w3-progress-container w3-grey">';
    echo '  <div id="myBar" class="w3-progressbar w3-orange" style="width:'.$row["edge"].'%">';
    echo '    <div class="w3-center w3-text-white"><b>'.$row["e"].'/5</b></div>';
    echo '   </div>';
    echo ' </div>';

    echo ' <p>Stavfäste</p>';
    echo '<div class="w3-progress-container w3-grey">';
    echo ' <div id="myBar" class="w3-progressbar w3-green" style="width:'.$row["grip"].'%">';
    echo '    <div class="w3-center w3-text-white"><b>'.$row["g"].'/5</b></div>';
    echo '  </div>';
    echo ' </div></br>';

  }
  ?>
</div>
</div>
</br>



<div class="w3-row-padding" style="border-color:lightblue; border-style: solid; border-width: 5px;">
  <div class="w3-threethird">
    <h5>Pågående arbetsordrar</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
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
        echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
        echo "<td>".$row['orderID']."</td>";
        echo "<td>";
        foreach($pdo->query( 'select realName from SubPlace, SubPlaceWorkOrder where SubPlace.name = SubPlaceWorkOrder.name and SubPlaceWorkOrder.orderID = '.$row ['orderID'].';' ) as $brow){;
          echo $brow['realName']."</br>";
        }
        echo "</td>";
        echo "<td>".$row['type']."</td>";
        echo "<td>".$row['priority']."</td>";
        echo "<td>".$row['entF']." ".$row['entL']."</td>";
        echo "<td>".$row['info']."</td>";
        echo "<td>".$row['sentDate']."</td>";
        echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
        echo "<td>";
        ?>
        <form id="rad<?php echo $row['orderID']; ?>">
          <input type="hidden" name="orderID1" value="<?php echo $row['orderID']; ?>">
          <button class="fa fa-check HoverButton" type="button" onclick="SendForm('index', 'index', 'rad<?php echo $row['orderID']; ?>');">Radera</button>
        </form>  
      </td>
      <td>
        <form id="klar<?php echo $row['orderID']; ?>">
          <input type="hidden" name="orderID2" value="<?php echo $row['orderID']; ?>">
           <button class="fa fa-check HoverButton" type="button" onclick="SendForm('index', 'index', 'klar<?php echo $row['orderID']; ?>');">Klarmarkera</button>
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
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
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

