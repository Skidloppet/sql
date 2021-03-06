<?php 
$i = 0;

foreach($pdo->query( 'select count(*)as i from Error;') as $row){
  $i = $row['i'];
}
?>

<div class="w3-container" style="padding-left:8px">
  <div class="w3-row-padding w3-margin-bottom">

   <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id01').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-red w3-padding-16">
      <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3><br></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Skapa ny felanmälan</h4>
    </div>
  </div>


  <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id077').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-green w3-padding-16">
      <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3><br></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Skapa ny arbetsorder</h4>
    </div>
  </div>


  
</div>




    <!-- The Modal -->
    <div id="id077" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container">
          <span onclick="document.getElementById('id077').style.display='none'"
          class="w3-closebtn">&times;</span>
          <h3>Skapa ny arbetsorder</h3>
          <form id="skapaAO2">

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
          <p>Entrepenör ansvarig * ( <i>Ej akut</i> )</p>
          <select name='EntID'>    
            <?php 
            foreach ($pdo->query('SELECT * FROM Ent where entID > 2') as $row) {
              echo '<option value="'.$row['entID'].'">';
              echo $row['firstName']." ".$row['lastName']."";
              echo "</option>";
            }
            ?></select> <input type="checkbox" name="split" value="1"> Tilldela till ansvarig entreprenör  ( <i>Ej akut</i> )

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
                <button type="button" onclick="SendForm('errorreport','errorreport','skapaAO2');" class="HoverButton" >Skicka</button>

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





    <div id="id01" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container">
          <span onclick="document.getElementById('id01').style.display='none'"
          class="w3-closebtn">&times;</span>


          <div id="11" class="w3-container">
            <h3>Ny felanmälan!</h3>
            <form id="ErrRep">
              <textarea rows="5" cols="70" name="desc" placeholder="Beskriv problemet..."></textarea>
            </br>

            <p>Ange problemets typ *</p>
            <select name="type">
              <?php
              $sql = 'SHOW COLUMNS FROM Error WHERE field="type"';
              $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
              foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
                print("<option>$option</option>");
              }
              ?>
            </select>

            <!-- Listbox till att välja startsträcka-->
            <p>Vart startade problemet?:</p>
            <select name='Start'>    
              <?php 
              foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
                echo '<option value="'.$row['name'].'">';
                echo $row['realName'];
                echo "</option>";
              }
              ?>
            </select><br>
            <!-- Listbox till att välja slutsträcka-->
            <p>Vart slutar problemets inverkan?:</p>
            <select name='Slut'>    
              <?php 
              foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
                echo '<option value="'.$row['name'].'">';
                echo $row['realName'];
                echo "</option>";
              }
              ?>
            </select><br><br>

            <!--<input type="text" name="Slut" placeholder="Slut.."></p>-->

            <button type="button" onclick="SendForm('errorreport', 'errorreport', 'ErrRep');">Ny Felanmälan</button></form>


            <?php
#  $em = $_SESSION['email'];

            if(isset($_POST['desc'])){

              $sql = "CALL _NewError(:newErrorDesc, :newEntID, NOW() , :newType, :startName, :endName);";

              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(":newErrorDesc", $_POST['desc'], PDO::PARAM_STR);
              $stmt->bindParam(":newEntID", $_SESSION['id'], PDO::PARAM_INT);
    //$stmt->bindParam(":newGrade", $_POST['grade'], PDO::PARAM_STR);
              $stmt->bindParam(":newType", $_POST['type'], PDO::PARAM_STR);
              $stmt->bindParam(":startName", $_POST['Start'], PDO::PARAM_INT);
              $stmt->bindParam(":endName", $_POST['Slut'], PDO::PARAM_INT);
              $stmt->execute();
            }    
            ?>
          </div>


        </div>
      </div>
    </div>
  </div>