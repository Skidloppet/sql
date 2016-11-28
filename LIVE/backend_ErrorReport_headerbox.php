
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Min kontrollpanel</b></h5>
  </header>
<?php
  include 'connect.php';
?>
<?php 
$LiveErrors = 0;
      foreach($pdo->query( 'select * from Error;' ) as $row){
        $LiveErrors = $row['errorID'];


          /*if ($row['rating'] >= 4){
            $SubPlaceNameArray[$row['rspName']] = $green;
          }
          else if ($row['rating'] <= 2){
            $SubPlaceNameArray[$row['rspName']] = $red;
          }
          else if ($row['rating'] = 3){
            $SubPlaceNameArray[$row['rspName']] = $yellow;
          }
          else{
            $SubPlaceNameArray[$row['rspName']]= $grey;
          }
          */
      }
    ?>
  <div class="w3-row-padding w3-margin-bottom">
    
     <div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id01').style.display='block'">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
    <div class="w3-right">
          <h3><br></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Skapa ny felanm�lan</h4>
      </div>
    </div>
    
     <div class="w3-third">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php print_r($LiveErrors); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Existerande felanm�lningar</h4>
      </div>
    </div>

  </div>


<div id="id01" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id01').style.display='none'"
      class="w3-closebtn">&times;</span>
     

<h3>Ny felanm�lan!</h3>
  <form action='backend_ErrorReport.php' method='POST'>
    <textarea rows="5" cols="70" name="desc" placeholder="Beskriv problemet..."></textarea>
    </br>
    <!--<p>Ange graden av problemets p�verkan</p>-->

    <!--<select name='grade'>
      <option selected="selected"> S�tt niv�</option>
      <option value="low">L�gt - P�verkar knappt</option>
      <option value="medium">Medium - P�verkar en del</option>
      <option value="high">H�g - P�verkar mycket</option>
      <option value="akut">Akut - Grovt problem</option>
    </select>
    <br><br> -->
    <p>Ange problemets typ:</p>
    <select name='type'>
      <option selected="selected"> S�tt typ</option>
      <option value="lights">Ljus - Lyktstolpar, liknande</option>
      <option value="tracks">Bana - Problem med banan</option>
      <option value="dirt">Smuts - Skr�p, kottar</option>
      <option value="trees">Tr�d - Som p�verkar banan</option>
      <option value="other">Annat</option>
    </select>
    <br>


    <!--<input type="text" name="type" placeholder="type.."></p>-->


    <!-- �ndra till session! (Entrepren�r) -->
    <!--<p>Ange ansvarig entrepren�rs id, ex: 1:</p>
    <input type="text" name="entID" placeholder="entID.."></p>
    -->

    <!-- Listbox till att v�lja startstr�cka-->
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


    <!--<input type="text" name="Start" placeholder="Start.."></p>-->


    <!-- Listbox till att v�lja slutstr�cka-->
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


    <p><button type="submit" name="Error">Ny felanm�lan</button></p></form>


  <?php
#  $em = $_SESSION['email'];

  if(isset($_POST['Error'])){

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