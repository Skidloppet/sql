
<?php
include '../connect.php';	
?>	
<?php
if(isset($_POST['orderID1'])){
  if ($_POST['type'] === "kanon" ){
   $querystring='DELETE FROM delCWO WHERE orderID = :orderID';

 }
 else {
   $querystring='DELETE FROM delWO WHERE orderID = :orderID';

 }
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':orderID', $_POST['orderID1'], PDO::PARAM_INT);
 $stmt->execute();
 echo "Arbetsorder borttagen";
}
?>
<?php
if(isset($_POST['orderID2'])){
  if ($_POST['type'] === "kanon" ){
   $querystring='CALL _finnishedCannonOrder(:orderID,'.$id.',NOW(),"Klarmarkerad av: '.$em.'")';
 }
 else {
   $querystring='CALL _finnishedWorkOrder(:orderID,'.$id.',NOW(),"Klarmarkerad av: '.$em.'")';
 }
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':orderID', $_POST['orderID2'],PDO::PARAM_INT);
 $stmt->execute();
 echo "Arbetsorder arkiverad";
}
?>
<?php
if(isset($_POST['orderID3'])){
 if ($_POST['type'] === "kanon" ){
  $sql = "call _newResponsabilityC (:_entID,:_orderID)";

}
else {
  $sql = "call _newResponsability (:_entID,:_orderID)";

}
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
<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:red; border-style: solid; border-width: 5px;">
            <div class="w3-container w3-section">
              <div class="w3-row-padding" style="margin:0 -16px">
                <div class="w3-threethird">
                  <h1>Akuta arbetsordrar</h1>
                  <table class="w3-table w3-striped w3-white">
                    <tr>
                      <th><u>Datum skickad</u></th>
                      <th>Arbetsorder-Typ</th>
                      <th>Område(n)</th>
                      <th>Prioritet</th>
                      <th>Information</th>
                      <th>Skapad av</th>
                      <th>Ange entrepenör</th>
                    </tr> 

                    <?php     
        # hämtar alla aktiva arbetsordrar(WorkOrder) som tillhör det autoangivna akutID (#1)
        # hemsidan visar entrepenörens förnamn och enfternamn genom kopplingen mellan

                    foreach($pdo->query( 'SELECT * FROM wo where priority="akut" and entID="1" order by sentDate desc;' ) as $row){
                     echo "<td>".$row['sentDate']."</td>";
                     echo "<td>".$row['type']."</td>";
                     echo "<td>";
                     if ($row['type'] === "kanon" ){
                      foreach($pdo->query( 'select realName from SubPlace,CannonSubPlace where SubPlace.name = CannonSubPlace.name and orderID = '.$row ['orderID'].';' ) as $brow){
                        echo $brow['realName']."</br>";
                      }} else {
                        foreach($pdo->query( 'select realName from SubPlace, SubPlaceWorkOrder where SubPlace.name = SubPlaceWorkOrder.name and SubPlaceWorkOrder.orderID = '.$row ['orderID'].';' ) as $brow){;
                          echo $brow['realName']."</br>";
                        }}
                        echo "</td>";
                        echo "<td>".$row['priority']."</td>";
                        echo "<td>".$row['info']."</td>";
                        echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
                        ?>
                        <td>
                          <form id="nyEnt<?php echo $row['orderID']; ?>">
                            <input type="hidden" name="orderID3" value="<?php echo $row['orderID']; ?>">
                            <input type="hidden" name="type" value="<?php echo $row['type']; ?>">
                            <select name='entID'>    
                              <?php 
              # i varje rad av svar den skriver ut så skapas en lista med alla Ent förnamn&efternamn
              # sätter value till entrepenöresns ID 
                              foreach ($pdo->query('SELECT * FROM Ent') as $rows) {
                                echo '<option value="'.$rows['entID'].'">';
                                echo $rows['firstName']." ".$rows['lastName'];
                                echo "</option>";
                              }
                              ?>
                            </select>
                            <button class="HoverButton" type="button" onclick="SendForm('index', 'index', 'nyEnt<?php echo $row['orderID']; ?>');"> skicka </button>
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

<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:lightblue; border-style: solid; border-width: 5px;">
  <?php
  include './map.php';
  ?>
</div>


<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:lightblue; border-style: solid; border-width: 5px;">
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



<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:lightblue; border-style: solid; border-width: 5px;">
      <div class="w3-threethird">
        <h5>Pågående arbetsordrar</h5>
        <table class="w3-table w3-striped w3-white">
          <tr>
            <th><u>Datum skickad</u></th>
            <th>Område(n)</th>
            <th>Arbetsorder-Typ</th>
            <th>Prioritet</th>
            <th>Ansvarig</th>
            <th>Information</th>
            <th>Skapad av</th>
            <th>Ta bort</th>
            <th>Arkivera</th>
          </tr>        
          <?php     

          foreach($pdo->query( 'SELECT * FROM wo order by sentDate desc;' ) as $row){
                echo "<td>".$row['sentDate']."</td>";
            echo "<td>";
            if ($row['type'] === "kanon" ){
              foreach($pdo->query( 'select realName from SubPlace,CannonSubPlace where SubPlace.name = CannonSubPlace.name and orderID = '.$row ['orderID'].';' ) as $brow){
                echo $brow['realName']."</br>";
              }} else {
                foreach($pdo->query( 'select realName from SubPlace, SubPlaceWorkOrder where SubPlace.name = SubPlaceWorkOrder.name and SubPlaceWorkOrder.orderID = '.$row ['orderID'].';' ) as $brow){;
                  echo $brow['realName']."</br>";
                }}
                echo "</td>";
                echo "<td>".$row['type']."</td>";
                echo "<td>".$row['priority']."</td>";
                echo "<td>".$row['entF']." ".$row['entL']."</td>";
                echo "<td>".$row['info']."</td>";
                echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
                ?>
                <td>
                  <form id="rade<?php echo $row['orderID']; ?>">
                    <input type="hidden" name="orderID1" value="<?php echo $row['orderID']; ?>">
                    <input type="hidden" name="type" value="<?php echo $row['type']; ?>">
                    <button class="fa fa-ban HoverButton" type="button" onclick="SendForm('index', 'index', 'rade<?php echo $row['orderID']; ?>');">Radera</button>
                  </form>  
                </td>
                <td>
                  <form id="lagr<?php echo $row['orderID']; ?>">
                    <input type="hidden" name="orderID2" value="<?php echo $row['orderID']; ?>">
                    <input type="hidden" name="type" value="<?php echo $row['type']; ?>">
                    <button class="fa fa-check HoverButton" type="button" onclick="SendForm('index', 'index', 'lagr<?php echo $row['orderID']; ?>');">Klarmarkera</button>
                  </form>
                </td>
              </tr>
              <?php
            }
            ?>   
          </table>
        </div>
      </div>
