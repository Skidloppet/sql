<?php 
$i = 0;
$i2 = 0;

      foreach($pdo->query( 'select count(*)as i from WorkOrder;') as $row){
        $i = $row['i'];
      }
      foreach($pdo->query( 'select count(*)as i from FinnishedWorkOrder;' ) as $row){
        $i2 = $row['i2'];
      }
       ?>

<header class="w3-container" style="padding-top:22px">
  <h4><b><i class="fa fa-dashboard"></i> Min kontrollpanel</b></h4>
</header>

<div class="w3-row-padding w3-margin-bottom">
  <div class="w3-third" onclick="document.getElementById('id01').style.display='block'">
    <div class="w3-container w3-green w3-padding-16">
      <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3><br></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Skapa ny arbetsorder</h4>
    </div>
  </div>



<div class="w3-third onclick="document.getElementById('id02').style.display='block'">
  <div class="w3-container w3-blue w3-padding-16">
    <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($i); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Pågående arbetsordrar</h4>
  </div>
</div>





<div class="w3-third onclick="document.getElementById('id03').style.display='block'">
  <div class="w3-container w3-red w3-padding-16">
    <div class="w3-left"><i class="fa fa-flag alt w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($i2); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Avslutade arbetsordrar</h4>
  </div>
</div>



</div>

<!-- The Modal -->
<div id="id01" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id01').style.display='none'"
      class="w3-closebtn">&times;</span>
      <h3>Skapa ny arbetsorder</h3>
<form action='<?php $_PHP_SELF ?>' method='POST'>
  <p>Prioritet:</p>
  <select name="Prioritering">
    <?php
    $sql = 'SHOW COLUMNS FROM WorkOrder WHERE field="priority"';
    $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
      print("<option>$option</option>");
    }
    ?>
  </select>

  <p>Typ:</p>
  <select name="type">
    <?php
    $sql = 'SHOW COLUMNS FROM WorkOrder WHERE field="type"';
    $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
      print("<option>$option</option>");
    }
    ?>
  </select></br></br>

  <textarea rows="5" cols="70" name="Info" placeholder="information om arbetsorder.."></textarea></br></br>
  <input type="text" name="EntID" placeholder="EntID.."></p>
  <select name='Start'>    
    <?php 
    foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
      echo '<option value="'.$row['name'].'">';
      echo $row['realName'];
      echo "</option>";
    }
    ?></select>    

    <select name='Slut'>    
      <?php 
      foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
        echo '<option value="'.$row['name'].'">';
        echo $row['realName'];
        echo "</option>";
      }
      ?></select>
      <input type="checkbox" name="split" value="1">dela upp på ansvarsområden<br>

      <p><button type="submit" name="_newSplitWorkOrder" id="_newWorkOrder">NEW Report</button></p></form>


      <?php
#try
      if(isset($_POST['_newSplitWorkOrder'])){

        $sql = "CALL _newSplitWorkOrder(:newSkiID, :newEntID, NOW() ,:newPriority, :newType, :newInfo, :newSplit, :startName, :endName)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":newSkiID", $id, PDO::PARAM_INT);
        $stmt->bindParam(":newEntID", $_POST['EntID'], PDO::PARAM_INT);
        $stmt->bindParam(":newPriority", $_POST['Prioritering'], PDO::PARAM_STR);
        $stmt->bindParam(":newType", $_POST['type'], PDO::PARAM_STR);
        $stmt->bindParam(":newInfo", $_POST['Info'], PDO::PARAM_STR);
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
<div id="id02" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id02').style.display='none'"
      class="w3-closebtn">&times;</span>
<h5>Pågående arbetsordrar</h5>
          <table class="w3-table w3-striped w3-white">
            <tr>
              <td><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></td>
              <td>OrderID</td>
              <td>skiID</td>
              <td>entID</td>
              <td>SentDate</td>
              <td>priority</td>
            </tr>        
            <?php     

            foreach($pdo->query( 'SELECT * FROM WorkOrder;' ) as $row){
              echo "<tr>";
              echo "<td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
              echo "<td><a href='finnishedWorkOrder.php?orderID=".urlencode($row['orderID'])."'>".$row['orderID']."</td>";
              echo "<td>".$row['skiID']."</td>";
              echo "<td>".$row['entID']."</td>";
              echo "<td>".$row['sentDate']."</td>";
              echo "<td>".$row['priority']."</td>";
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
                <h4>avslutade arbetsordrar</h4>
                <table class="w3-table w3-striped w3-white">
                  <tr>
                    <td><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></td>
                    <td>OrderID</td>
                    <td>skiID</td>
                    <td>entID</td>
                    <td>SentDate</td>
                    <td>priority</td>
                  </tr>        
                  <?php     
            # limit på dagar eller antal
                  foreach($pdo->query( 'SELECT * FROM FinnishedWorkOrder;' ) as $row){
                    echo "<tr>";
                    echo "<td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
                    echo "<td><a href='finnishedWorkOrder.php?orderID=".urlencode($row['orderID'])."'>".$row['orderID']."</td>";
                    echo "<td>".$row['skiID']."</td>";
                    echo "<td>".$row['entID']."</td>";
                    echo "<td>".$row['sentDate']."</td>";
                    echo "<td>".$row['priority']."</td>";
                    echo "</tr>";  
                  }
                  ?>   
                </table>
    </div>
  </div>
</div>