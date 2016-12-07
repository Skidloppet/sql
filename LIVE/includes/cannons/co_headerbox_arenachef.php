

<div class="w3-row-padding w3-margin-bottom">



  <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id02').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-brown w3-padding-16">
      <div class="w3-left"><i class="fa fa-bolt w3-xxxlarge"></i></div>
      <div class="w3-right">
      </div>
      <div class="w3-clear"></div>
      <h4>Ändra Snökanoner</h4>
    </div>
  </div>




  <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id01').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge  w3-container w3-brown w3-padding-16">
      <div class="w3-left"><i class="fa fa-plus-square w3-xxxlarge"></i></div>
      <div class="w3-right">
      </div>
      <div class="w3-clear"></div>
      <h4>Skapa ny Snökanon</h4>
    </div>
  </div>





  <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id03').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-brown w3-padding-16">
      <div class="w3-left"><i class="fa fa-ban alt w3-xxxlarge"></i></div>
      <div class="w3-right">
      </div>
      <div class="w3-clear"></div>
      <h4>Ta bort snökanon</h4>
    </div>
  </div>


  <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id044').style.display='block'">
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

<!-- The Modal -->
<div id="id01" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id01').style.display='none'"
      class="w3-closebtn">&times;</span>

      <div class="w3-threethird">
        <h3>Lägg till ny snökanon</h3>


        <!--  form som skickar frågan (self funkar ej )  -->
        <form id="nykanon">
          <select size='1' name='state'>
            <option selected="selected"> Nuvarande tillstånd </option>
            <?php
            $sql = 'SHOW COLUMNS FROM Cannon WHERE field="state"';
            $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
              print("<option>$option</option>");
            }

            ?>
          </select></br></br>
          <select name='subPlaceName'>    
            <option selected="selected"> Nuvarande position </option>

            <?php 
            foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
              echo '<option value="'.$row['realName'].'">';
              echo $row['realName'];
              echo "</option>";
            }
            ?></select></br></br>
            <select name='model'>
              <option selected="selected"> Modell-typ </option>    
              <option value="STA1">Stationär</option>
              <option value="MOV1">transportabel</option>
            </select>
            <p>Effekt m&#179/min </p>
            <input type="text" name="effect" placeholder=".."></p>
            <p>Modell</p>
            <input type="text" name="klass" placeholder=".."></p>
            <button class="fa fa-check HoverButton" type="button" onclick="SendForm('cannons', 'cannons', 'nykanon');">Skapa</button>
          </form>

          <?php
          if(isset($_POST['subPlaceName'])){
            $sql="CALL NewCannon(:subPlaceName,:model,:state,:effect, :klass)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':subPlaceName', $_POST['subPlaceName'],PDO::PARAM_INT);
            $stmt->bindParam(':model', $_POST['model'],PDO::PARAM_STR);
            $stmt->bindParam(':state', $_POST['state'],PDO::PARAM_STR);
            $stmt->bindParam(':effect', $_POST['effect'],PDO::PARAM_INT);
            $stmt->bindParam(':klass', $_POST['klass'],PDO::PARAM_STR);
            $stmt->execute();
          }
          ?>
        </div>
      </div>
    </div>
  </div>




  <!-- The Modal -->
  <div id="id02" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id02').style.display='none'"
        class="w3-closebtn">&times;</span>



        <div class="w3-threethird">
          <h3>ändra snökanon</h3>
          <form id="andra">
            <select size='1' name='cannonID1'>
              <option selected="selected"> Välj kanon </option>
              <?php    
              foreach($pdo->query( 'SELECT * FROM Cannon ORDER BY cannonID;' ) as $row){
                echo '<option value="'.$row['cannonID'].'">';
                echo $row['cannonID'];      
                echo '</option>';
              }    
              ?>
            </select>
            <select size='1' name='subPlaceName'>
              <option selected="selected"> plats </option>
              <?php    
              foreach($pdo->query( 'SELECT * FROM SubPlace ;' ) as $row){
          # GROUP BY G?R S? DET EJ BLIR DUBLETTER
                echo '<option value="'.$row['realName'].'">';
                echo $row['realName'];      
                echo '</option>';
              }    
              ?>
            </select>

            <select size='1' name='state'>
              <option selected="selected"> status </option>
              <?php
              $sql = 'SHOW COLUMNS FROM Cannon WHERE field="state"';
              $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
              foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
                print("<option>$option</option>");
              }

              ?>
            </select>
            <button class="fa fa-check HoverButton" type="button" onclick="SendForm('cannons', 'cannons', 'andra');">Ändra</button>
          </form>

          <?php 
          if(isset($_POST['cannonID1'])){
            $querystring='Call AlterCannon (:cannonID, :subPlaceName, :state);';
            $stmt = $pdo->prepare($querystring);
            $stmt->bindParam(':cannonID', $_POST['cannonID1']);
            $stmt->bindParam(':subPlaceName', $_POST['subPlaceName']);
            $stmt->bindParam(':state', $_POST['state']);
            $stmt->execute();

          }
          ?>
        </div>
      </div>
    </div>
  </div>








        <!-- The Modal -->
        <div id="id044" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('id044').style.display='none'"
              class="w3-closebtn">&times;</span>
              <h3>Skicka förfrågan</h3>

              <form id="skapaCAO2">
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
                    <button type="button" onclick="SendForm('cannons','cannons','skapaCAO2');" class="HoverButton" >Skicka</button>
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
  <h5></h5>
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
  <div id="id03" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id03').style.display='none'"
        class="w3-closebtn">&times;</span>
        <div class="w3-threethird">
          <h3>Radera snökanon</h3>
          <form id="radera">
            <select size='1' name='cannonID2'>
              <option selected="selected"> Välj kanon </option>
              <?php    
              foreach($pdo->query( 'SELECT * FROM Cannon ORDER BY cannonID;' ) as $row){
                echo '<option value="'.$row['cannonID'].'">';
                echo $row['klass']." ( ".$row['cannonID']." ) ";      
                echo '</option>';
              }    
              ?>
            </select>

            <button class="fa fa-check HoverButton" type="button" onclick="SendForm('cannons', 'cannons', 'radera');">Radera</button>
          </form>

          <?php
          if(isset($_POST['cannonID2'])){
           $querystring='DELETE FROM delCA WHERE cannonID = :cannonID';
           $stmt = $pdo->prepare($querystring);
           $stmt->bindParam(':cannonID', $_POST['cannonID2'], PDO::PARAM_INT);
           $stmt->execute();
           echo "Snökanon borttagen";
         }
         ?>

       </div>
     </div>
   </div>
 </div>