<h2>Översikt</h2>

<?php
include './connect.php';	
?>	
<div class="w3-container w3-section">
  <div class="w3-row-padding" style="margin:0 -16px">
   <div class="w3-threethird">
    <h4>akuta arbetsordrar</h4>
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

      foreach($pdo->query( 'SELECT * FROM WorkOrder where priority="akut" and entID="1";' ) as $row){
        echo "<tr>";
        echo "<td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
        echo "<td><a href='backend_wo.php?akutOrderID=".urlencode($row['orderID'])."'>".$row['orderID']."</td>";
        echo "<td>".$row['skiID']."</td>";
        echo "<td>".$row['entID']."</td>";
        echo "<td>".$row['sentDate']."</td>";
        echo "<td>".$row['priority']."</td>";
        echo "</tr>";  
      }
      ?>   
    </table>
  </div>


  <div class="w3-container w3-section">
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


      <div class="w3-threethird">
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




      <div class="w3-threethird">
        <h4>mottagna akuta arbetsordrar(entID!= 1)</h4>
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

          foreach($pdo->query( 'SELECT * FROM WorkOrder where priority="akut" and entID!="1";' ) as $row){
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


<!--
Ny arbetsorder!
förbättringsmöjligheter:
alt. skapa json som tar bort input 'entID' om man kör split
skapa dropdown alternativ för prio & type? (går att fixa en php funktion man kan skapa för att hantera alla ENUM dropdown (återanvändningsbar kod för FLERA enum inputs))
-->
<div id ="11" class="w3-container">
  <h3>Add a new workorder!</h3>
  <form action='<?php $_PHP_SELF ?>' method='POST'>
    <input type="text" name="SkiID" placeholder="SkiID..(session)"></p>
    <input type="text" name="Prioritering" placeholder="Prioritering..(low,akut)"></p>
    <input type="text" name="type" placeholder="type (tracks, trees osv.)"></p>
    <input type="text" name="Info" placeholder="Info.."></p>
    <input type="checkbox" name="split" value="1">split order for each track 'owner' <br>
    <input type="text" name="EntID" placeholder="EntID.."></p>
    <input type="text" name="Start" placeholder="Start.."></p>
    <input type="text" name="Slut" placeholder="Slut.."></p>
    <p><button type="submit" name="_newSplitWorkOrder" id="_newWorkOrder">NEW Report</button></p></form>


    <?php
#try
    if(isset($_POST['_newSplitWorkOrder'])){

      $sql = "CALL _newSplitWorkOrder(:newSkiID, :newEntID, NOW() ,:newPriority, :newType, :newInfo, :newSplit, :startName, :endName)";

      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":newSkiID", $_POST['SkiID'], PDO::PARAM_INT);
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






  <div id="12"class="w3-container">
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


    </div>
  </div>