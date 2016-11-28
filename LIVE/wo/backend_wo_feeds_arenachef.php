
<?php
include './connect.php';	
?>	

<?php
      
  if(isset($_GET['orderID'])){
       $querystring='DELETE FROM WorkOrder WHERE orderID = :orderID';
       #$querystring = 'DELETE FROM SubPlaceWorkOrder WHERE orderID = :orderID';
       $stmt = $pdo->prepare($querystring);
       $stmt->bindParam(':orderID', $_GET['orderID']);
       $stmt->execute();
       echo "Arbetsorder borttagen";

    }
    ?>


<div class="w3-container w3-orange w3-section">
  <h2>Översikt</h2>
  <div class="w3-row-padding" style="margin:0 -16px">
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
          <th>Ta bort</th>
        </tr>        
        <?php     

        foreach($pdo->query( 'SELECT * FROM wo;' ) as $row){
          echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
          echo "<td>".$row['orderID']."</td>";
          echo "<td>".$row['type']."</td>";
          echo "<td>".$row['priority']."</td>";
          echo "<td>".$row['entF']." ".$row['entL']."</td>";
          echo "<td>".$row['info']."</td>";
          echo "<td>".$row['sentDate']."</td>";
          echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
          echo "<td><a href='backend_wo.php?orderID=".$row['orderID']."'>Ta bort</a></td>";
          echo "</tr>";  
        }
        ?>   
      </table>
    </div>



  </div>

  <div class="w3-container w3-section">
    <div class="w3-row-padding" style="margin:0 -16px">
     <div class="w3-threethird">
      <h4>akuta arbetsordrar</h4>
      <table class="w3-table w3-striped w3-white">
        <tr>
          <td><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></td>
          <th>Order ID</th>
          <th>Arbetsorder-Typ</th>
          <th>Prioritet</th>
          <th>Information</th>
          <th>Datum skickad</th>
          <th>Skapad av</th>
          <th>Ange entrepenör</th>
        </tr> 



        <form action='<?php $_PHP_SELF ?>' method='POST'>       
          <?php     
        # hämtar alla aktiva arbetsordrar(WorkOrder) som tillhör det autoangivna akutID (#1)
        # hemsidan visar entrepenörens förnamn och enfternamn genom kopplingen mellan
          foreach($pdo->query( 'SELECT * FROM wo where priority="akut" and entID="1";' ) as $row){
            echo "<tr>";
            echo "<td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
            echo "<td name='orderID'>".$row['orderID']."</td>";
            echo "<td>".$row['type']."</td>";
            echo "<td>".$row['priority']."</td>";
            echo "<td>".$row['entF']." ".$row['entL']."</td>";
            echo "<td>".$row['info']."</td>";
            echo "<td>".$row['sentDate']."</td>";
            echo "<td>"
            ?>

            <select name='entID'>    
              <?php 
              # i varje rad av svar den skriver ut så skapas en lista med alla Ent förnamn&efternamn
              # sätter value till entrepenöresns ID 
              foreach ($pdo->query('SELECT * FROM Ent') as $row) {
                echo '<option value="'.$row['entID'].'">';
                echo $row['firstName']." ".$row['lastName'];
                echo "</option>";
              }
              ?>
            </select><p><button type="submit" name="newEnt">Sätt entrepenör ansvar</button></p>
          </form>

          <?php
          echo "</td></tr>";  
        }
        ?>   
      </table>
    </div>

<!-- frågan om att byta entrepenör ansvarig för arbetsorder till DB



fungerar ej.

-->
<?php
if(isset($_POST['newEnt'])){
  $sql = "call _newResponsability (:_entID,:_orderID)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":_entID", $_POST['entID'], PDO::PARAM_INT);
  $stmt->bindParam(":_orderID", $_POST['orderID'], PDO::PARAM_INT);
  $stmt->execute();
}    
?>
</div>
</div>


</br></br></br></br></br>

</div>





<div id ="11" class="w3-container w3-green" >
</br>
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


    <div id=""class="w3-container w3-blue w3-section">
      <div class="w3-row-padding" style="margin:0 -16px">
        <div class="w3-threethird">
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





        <div id="12"class="w3-container w3-blue">
          <h5>Entrepenörernas nästa planerade arbetspass</h5>
          <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <tr>
              <th>Name</th>
              <th>latest shift</th>
              <th>next planned</th>
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
            <select name="entID">
              <option>Entrepenörer</option>
              <?php    
              foreach($pdo->query( 'SELECT * FROM Ent; ' ) as $row){
                echo '<option value="'.$row['entID'].'">';
                echo $row['firstName']." ".$row['lastName']." (".$row['entID'].")";      
                echo '</option>'; } ?> 
              </select> 
              <select name="orderID">
                <option >Arbetsorder ID</option>
                <?php    
                foreach($pdo->query( 'SELECT * FROM WorkOrder; ' ) as $row){
                  echo '<option value="'.$row['orderID'].'">';
                  echo $row['orderID'];      
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


              <div class="w3-threethird w3-red" ID="13">
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
