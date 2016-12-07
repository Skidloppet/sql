

<div class="w3-row-padding w3-margin-bottom">



  <div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id02').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-brown w3-padding-16">
      <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
      <div class="w3-right">
      </div>
      <div class="w3-clear"></div>
      <h4>Hantera Snökanoner</h4>
    </div>
  </div>




  <div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id01').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge  w3-container w3-brown w3-padding-16">
      <div class="w3-left"><i class="fa fa-plus-square w3-xxxlarge"></i></div>
      <div class="w3-right">
      </div>
      <div class="w3-clear"></div>
      <h4>Skapa ny Snökanon</h4>
    </div>
  </div>





  <div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id03').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-brown w3-padding-16">
      <div class="w3-left"><i class="fa fa-ban alt w3-xxxlarge"></i></div>
      <div class="w3-right">
      </div>
      <div class="w3-clear"></div>
      <h4>Ta bort snökanon</h4>
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