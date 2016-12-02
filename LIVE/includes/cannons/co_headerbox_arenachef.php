<?php 
$i = 0;
$i2 = 0;

foreach($pdo->query( 'select count(*)as i from WorkOrder;') as $row){
  $i = $row['i'];
}
foreach($pdo->query( 'select count(*)as i2 from FinnishedWorkOrder;' ) as $row){
  $i2 = $row['i2'];
}
?>


<div class="w3-row-padding w3-margin-bottom">

 <div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id01').style.display='block'">
  <div class="w3-container w3-green w3-padding-16">
    <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><br></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Skapa ny Snökanon</h4>
  </div>
</div>



<div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id02').style.display='block'">
  <div class="w3-container w3-blue w3-padding-16">
    <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($i); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Hantera Snökanoner</h4>
  </div>
</div>





<div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id03').style.display='block'">
  <div class="w3-container w3-red w3-padding-16">
    <div class="w3-left"><i class="fa fa-flag alt w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($i2); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>statestik? garage?</h4>
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
        <form action='<?php echo $_SERVER['SCRIPT_NAME']; ?>' method='POST'>
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
            <?php 
            foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
              echo '<option value="'.$row['realName'].'">';
              echo $row['realName'];
              echo "</option>";
            }
            ?></select></br>
            <p>Modellnamn</p>
            <input type="text" name="model" placeholder="modell.."></p>
            <p>Effekt m&#179/min (ex: <b>1.123</b>)</p>
            <input type="text" name="effect" placeholder="effekt.."></p>
            <p>asd</p>
            <input type="text" name="klass" placeholder="klass.."></p>
            <input type="submit" value="Lägg till"/>
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


        <div class="w3-row-padding" style="margin:0 -16px">

          <div class="w3-container w3-pink">
            <h3>ändra snökanon</h3>
            <form action='<?php $_PHP_SELF ?>' method='POST'>
              <select size='1' name='cannonID'>
                <option selected="selected"> välj kanon </option>
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
                  echo '<option value="'.$row['subPlaceName'].'">';
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
              <input type="submit" value="Send" name="send">
              <input type="reset"></form>

              <?php 
              if(isset($_POST['send'])){
                $querystring='Call AlterCannon (:cannonID, :subPlaceName, :state);';
                $stmt = $pdo->prepare($querystring);
                $stmt->bindParam(':cannonID', $_POST['cannonID']);
                $stmt->bindParam(':subPlaceName', $_POST['subPlaceName']);
                $stmt->bindParam(':state', $_POST['state']);
                $stmt->execute();

              }
              ?>
            </div>
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
            <h5>Pågående arbetsordrar</h5>
            <table class="w3-table w3-striped w3-white">
              <tr>
                <th><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></th>
                <th>Order ID</th>
                <th>Arbetsorder-Typ</th>
                <th>Prioritet</th>
                <th>Ansvarig</th>
                <th>Information</th>
                <th>Datum skickad</th>
                <th>Skapad av</th>
              </tr>        
              <?php     

              foreach($pdo->query( 'SELECT * FROM fwo order by orderID desc;' ) as $row){
                echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
                echo "<td>".$row['orderID']."</td>";
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