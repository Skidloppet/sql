<?php 
$i = 0;
$i2 = 0;

foreach($pdo->query( 'select count(*)as i from wo;') as $row){
  $i = $row['i'];
}
foreach($pdo->query( 'select count(*)as i2 from fwo;' ) as $row){
  $i2 = $row['i2'];
}
?>


<div class="w3-row-padding w3-margin-bottom">

 <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id01').style.display='block'">
  <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-green w3-padding-16">
    <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><br></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Skapa ny arbetsorder</h4>
  </div>
</div>





<div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id02').style.display='block'">
  <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-green w3-padding-16">
    <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php #print_r($i);?> </br> </h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Se planerade arbetspass</h4>
  </div>
</div>





<div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id03').style.display='block'">
  <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-green w3-padding-16">
    <div class="w3-left"><i class="fa fa-flag alt w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($i2); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Avslutade arbetsordrar</h4>
  </div>
</div>


<div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id04').style.display='block'">
  <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-brown w3-padding-16">
    <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><br></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Hantera snökanoner</h4>
  </div>
</div>

</div>




<div class="w3-container w3-section">

  <div class="w3-row-padding" style="margin:0 -16px; padding-left: 20px;">




    <!-- The Modal -->
    <div id="id01" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container">
          <span onclick="document.getElementById('id01').style.display='none'"
          class="w3-closebtn">&times;</span>
          <h3>Skapa ny arbetsorder</h3>
          <form id="skapaAO">

            <p>Prioritet  *</p>
            <select name="Prioritering">
              <?php
              $sql = 'SHOW COLUMNS FROM WorkOrder WHERE field="priority"';
              $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
              foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
                print("<option>$option</option>");
              }
              ?>
            </select>

            <p>Typ  *</p>
            <select name="type">
              <?php
              $sql = 'SHOW COLUMNS FROM WorkOrder WHERE field="type"';
              $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
              foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
                print("<option>$option</option>");
              }
              ?>
            </select>


          </br></br>


          <textarea rows="5" cols="70" name="info1" placeholder="information om arbetsorder.."></textarea></br></br>
          <p>Entrepenör ansvarig *</p>
          <select name='EntID'>    
            <?php 
            foreach ($pdo->query('SELECT * FROM Ent') as $row) {
              echo '<option value="'.$row['entID'].'">';
              echo $row['firstName']." ".$row['lastName']." (".$row['entID'].") ";
              echo "</option>";
            }
            ?></select>   <br><br>

            <p>Välj plats(er) *</p>
            <select name='Start'>    
              <?php 
              foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
                echo '<option value="'.$row['name'].'">';
                echo $row['realName'];
                echo "</option>";
              }
              ?></select>  

              <select name='Slut' >    
                <?php 
                echo '<option selected="selected" value="Q" > Välj t.o.m delsträcka ';
                foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
                  echo '<option value="'.$row['name'].'">';
                  echo $row['realName'];
                  echo "</option>";
                }
                ?></select><br><br>
                <input type="checkbox" name="split" value="1"> Dela upp på delsträckor ( <i>Ej akut*</i> )<br><br>
                <button type="button" onclick="SendForm('workorder','workorder','skapaAO');" class="HoverButton" >Skicka</button>

              </form>

              <?php
#try
              if(isset($_POST['info1'])){

              # Frågan till proceduren
                $sql = "CALL _newSplitWorkOrder(:newSkiID, :newEntID, NOW() ,:newPriority, :newType, :newInfo, :newSplit, :startName, :endName)";

              # hantera när ingen slutstation är vald (gör så slut blir desamma som start)
                if($_POST['Slut'] === "Q") {
                  $_POST['Slut'] = $_POST['Start'];
                }				

              # kontroll om akut (isf default ent, så alla kan acceptera samt stoppar eventuellt försök på split för ansvarsområden)

                if ($_POST['Prioritering'] == "Akut"){
                  $_POST['EntID'] = "1";
                  $_POST['split'] = "0";

                  $response = file_get_contents($sms_url . "?" . $parameters);
                }


                $stmt = $pdo->prepare($sql);
              # OBS -> skiID tas från session.
                $stmt->bindParam(":newSkiID", $id, PDO::PARAM_INT);
                $stmt->bindParam(":newEntID", $_POST['EntID'], PDO::PARAM_INT);
                $stmt->bindParam(":newPriority", $_POST['Prioritering'], PDO::PARAM_STR);
                $stmt->bindParam(":newType", $_POST['type'], PDO::PARAM_STR);
                $stmt->bindParam(":newInfo", $_POST['info1'], PDO::PARAM_STR);
                $stmt->bindParam(":newSplit", $_POST['split'], PDO::PARAM_INT);
                $stmt->bindParam(":startName", $_POST['Start'], PDO::PARAM_INT);
                $stmt->bindParam(":endName", $_POST['Slut'], PDO::PARAM_INT);
                $stmt->execute();
              }
              ?>
            </div>
          </div>
        </div>












        <!-- The Modal -->
        <div id="id04" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('id04').style.display='none'"
              class="w3-closebtn">&times;</span>
              <h3>Skicka förfrågan</h3>

              <form id="skapaCAO">
                <p>Välj snökanon  *</p>
                <select name='cannonID'>    
                  <?php 
                  foreach ($pdo->query('SELECT * FROM Cannon') as $row) {
                    echo '<option value="'.$row['cannonID'].'">';
                    echo "( ".$row['cannonID']." )".$row['klass'];
                    echo "</option>".$row['state'];
                  }
                  ?></select> 
                  <p>Ange ny position  *</p>

                  <select name='name'>    
                    <?php 
                    foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
                      echo '<option value="'.$row['name'].'">';
                      echo $row['realName'];
                      echo "</option>";
                    }
                    ?></select>    


                    <p>Ange ny status  *</p>
                    <select name="state">
                      <?php
                      $sql = 'SHOW COLUMNS FROM Cannon WHERE field="state"';
                      $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
                      foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
                        print("<option>$option</option>");
                      }
                      ?>
                    </select>

                    <p>Entrepenör ansvarig <i>(ej akut)</i>  *</p>
                    <select name='EntID'>    
                      <?php 
                      foreach ($pdo->query('SELECT * FROM Ent') as $row) {
                        echo '<option value="'.$row['entID'].'">';
                        echo $row['firstName']." ".$row['lastName']." (".$row['entID'].") ";
                        echo "</option>";
                      }
                      ?></select> 

                      <p>Sätt prioritet  *</p>
                      <select name="Prioritering">
                        <?php
                        $sql = 'SHOW COLUMNS FROM WorkOrder WHERE field="priority"';
                        $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
                        foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
                          print("<option>$option</option>");
                        }
                        ?>
                      </select>
                    </br></br>
                    <textarea rows="5" cols="70" name="info2" placeholder="information om arbetsorder.."></textarea></br></br>
                    <button type="button" onclick="SendForm('workorder','workorder','skapaCAO');" class="HoverButton" >Skicka</button>
                  </form>

<!--
cannonID smallint,
name smallint,
skiID smallint,
entID smallint,
startStamp datetime,
priority enum('low','medium','high','akut'),
newStatus enum('on','off','unplugged','broken'),
info varchar (1024))
-->

<?php
#try

if(isset($_POST['info2'])){
    
              # Frågan till proceduren
  $sql = "CALL _newCannonOrder(:cannonID, :name, :skiID, :entID, NOW() ,:priority, :state, :info)";

              # kontroll om akut (isf default ent, så alla kan acceptera samt stoppar eventuellt försök på split för ansvarsområden)
  if ($_POST['Prioritering'] == "akut"){
    $_POST['EntID'] = "1";
  }

  $stmt = $pdo->prepare($sql);
              # OBS -> skiID tas från session.
  $stmt->bindParam(":skiID", $id, PDO::PARAM_INT);
  $stmt->bindParam(":cannonID", $_POST['cannonID'], PDO::PARAM_INT);
  $stmt->bindParam(":entID", $_POST['EntID'], PDO::PARAM_INT);
  $stmt->bindParam(":priority", $_POST['Prioritering'], PDO::PARAM_STR);
  $stmt->bindParam(":info", $_POST['info2'], PDO::PARAM_STR);
  $stmt->bindParam(":name", $_POST['name'], PDO::PARAM_INT);
  $stmt->bindParam(":state", $_POST['state'], PDO::PARAM_STR);
  $stmt->execute();
}
?>
</div>

<div class="w3-threethird w3-margin w3-padding">
  <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
    <tr>
      <th><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></th>
      <th>Modell (id)</th>
      <th>Position</th>
      <th>Status</th>
      <th>Effekt</th>
    </tr>        
    <?php     

    foreach($pdo->query( 'SELECT * FROM ca order by cannonID desc;' ) as $row){
      echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
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

    </div>












    <!-- The Modal -->
    <div id="id02" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container w3-margin w3-padding">
          <span onclick="document.getElementById('id02').style.display='none'"
          class="w3-closebtn">&times;</span>

          <h5>Entrepenörernas nästa planerade arbetspass</h5>
          <h5>Proceduren måste ändras så den kollar på StoredReports</h5>
          <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <tr>
              <th>Namn</th>
              <th>Senaste arbetspass</th>
              <th>Nästa planerade pass</th>
            </tr>
            <?php
    # kolla procedur entWork...
            foreach($pdo->query( 'SELECT * FROM entWork;' ) as $row){

              echo ' <tr>';
              echo ' <td>'.$row["firstName"].' '.$row["lastName"].'</td>';
              echo ' <td>'.$row["startDate"].'</td>';
              echo ' <td>'.$row["date"].'</td>';
              echo ' </tr>';
            }

            ?>
          </table><br>
        </div>

      </div>
    </div>
    <?php
# funk för att ändra ansvar på pågående order.
    if(isset($_POST['orderID'])){
      $sql = "call _newResponsability (:_entID,:_orderID)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":_entID", $_POST['entID'], PDO::PARAM_INT);
      $stmt->bindParam(":_orderID", $_POST['orderID'], PDO::PARAM_INT);
      $stmt->execute();
    }    
    ?>




    <!-- The Modal -->
    <div id="id03" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container w3-padding w3-margin w3-border-top">
          <span onclick="document.getElementById('id03').style.display='none'"
          class="w3-closebtn">&times;</span>
          <div class="w3-threethird">
            <h5>Avslutade arbetsordrar</h5>
            <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
              <tr>
                <th>Påverkade sträckor</th>
                <th>Arbetsorder-Typ</th>
                <th>Prioritet</th>
                <th>Ansvarig</th>
                <th>Information</th>
                <th>Datum skickad</th>
                <th>Skapad av</th>
              </tr>        
              <?php     

              foreach($pdo->query( 'SELECT * FROM fwo order by orderID desc;' ) as $row){
                echo "<tr><td>";
                if ($row['type'] === "kanon" ){
                  foreach($pdo->query( 'select realName from SubPlace,FinnishedCannonSubPlace where SubPlace.name = FinnishedCannonSubPlace.name and orderID = '.$row ['orderID'].';' ) as $brow){
                    echo $brow['realName']."</br>";
                  }} else {
                    foreach($pdo->query( 'select realName from SubPlace, FinnishedSubPlaceWorkOrder where SubPlace.name = FinnishedSubPlaceWorkOrder.name and FinnishedSubPlaceWorkOrder.orderID =  '.$row ['orderID'].';' ) as $brow){;
                      echo $brow['realName']."</br>";
                    }}
                    echo "</td>";
                    echo "<td>".$row['type']."</td>";
                    echo "<td>".$row['priority']."</td>";
                    echo "<td>".$row['entF']." ".$row['entL']."</td>";
                    echo "<td>".$row['info']."</td>";
                    echo "<td>".$row['sentDate']."</td>";
                    echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
                    echo "</tr>";  
                  }
                  ?>   
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>