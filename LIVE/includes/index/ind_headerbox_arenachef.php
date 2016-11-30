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
    <h4>Skapa ny arbetsorder</h4>
  </div>
</div>



<div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id02').style.display='block'">
  <div class="w3-container w3-blue w3-padding-16">
    <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($i); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Pågående arbetsordrar</h4>
  </div>
</div>





<div class="w3-third" style="cursor:pointer" onclick="document.getElementById('id03').style.display='block'">
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


      <textarea rows="5" cols="70" name="Info" placeholder="information om arbetsorder.."></textarea></br></br>
      <p>Entrepenör ansvarig <i>(ej akut)</i>  *</p>
      <select name='EntID'>    
        <?php 
        foreach ($pdo->query('SELECT * FROM Ent') as $row) {
          echo '<option value="'.$row['entID'].'">';
          echo $row['firstName']." ".$row['lastName']." (".$row['entID'].") ";
          echo "</option>";
        }
        ?></select>   

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
            echo '<option selected="selected" value"0"> Välj t.o.m delsträcka ';
            foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
              echo '<option value="'.$row['name'].'">';
              echo $row['realName'];
              echo "</option>";



            }
            ?></select>
            <input type="checkbox" name="split" value="1"> Dela upp på ansvarsområden<br>

            <p><button type="submit" name="_newSplitWorkOrder" id="_newWorkOrder">Skicka</button></p></form>


            <?php
#try
            if(isset($_POST['_newSplitWorkOrder'])){

              $sql = "CALL _newSplitWorkOrder(:newSkiID, :newEntID, NOW() ,:newPriority, :newType, :newInfo, :newSplit, :startName, :endName)";

              if ($_POST['Prioritering'] == "akut"){
                $_POST['EntID'] = "1";
                $_POST['split'] = "0";
              }

              #hantera när ingen slutstation är vald

           if ($_POST['Slut'] = "0"){
                $_POST['Slut'] = $_POST['Start']; 
              }

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

          <div class="w3-container w3-blue">
            <h3>Ändra ansvar för en arbetsorder till ny entrepenör</h3>
            <form action='<?php $_PHP_SELF ?>' method='POST'>
              <select name="orderID">
                <option >Arbetsorder ID</option>
                <?php    
                foreach($pdo->query( 'SELECT * FROM WorkOrder order by orderID desc; ' ) as $row){
                  echo '<option value="'.$row['orderID'].'">';
                  echo $row['orderID'];      
                  echo '</option>'; } ?> 
                </select>
                <select name="entID">
                  <option>Entrepenörer</option>
                  <?php    
                  foreach($pdo->query( 'SELECT * FROM Ent; ' ) as $row){
                    echo '<option value="'.$row['entID'].'">';
                    echo $row['firstName']." ".$row['lastName']." (".$row['entID'].")";      
                    echo '</option>'; } ?> 
                  </select> 

                  <button type="submit" name="send">BYT</button></form>


                  <?php

                  if(isset($_POST['send'])){
                    $sql = "call _newResponsability (:_entID,:_orderID)";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":_entID", $_POST['entID'], PDO::PARAM_INT);
                    $stmt->bindParam(":_orderID", $_POST['orderID'], PDO::PARAM_INT);
                    $stmt->execute();

            # DEN UPPDATERAR INTE LISTAN OVAN (endast om man laddar om sidan..)
                    header("refresh: 3;");
                  }    
                  ?>
                  <hr>
                </div>


                <div class="w3-threethird">
                  <h5>Pågående arbetsordrar (senaste 20st)</h5>
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

                    foreach($pdo->query( 'SELECT * FROM wo order by orderID desc;' ) as $row){
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