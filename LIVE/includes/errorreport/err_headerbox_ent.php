<?php 
$i = 0;

foreach($pdo->query( 'select count(*)as i from Error;') as $row){
  $i = $row['i'];
}
?>

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


  <a href="#12">
    <div class="w3-quarter">
      <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php print_r($i); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Aktuella felanmälningar</h4>
      </div>
    </div>
  </a>
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

        <button type="button" onclick="SendForm('errorreport', 'errorreport', 'ErrRep');">Skicka</button></form>


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