
<?php
include './connect.php';	
?>	

<?php

if(isset($_GET['orderID'])){
 $querystring='DELETE FROM WorkOrder WHERE orderID = :orderID';
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':orderID', $_GET['orderID']);
 $stmt->execute();
 echo "Arbetsorder borttagen";
}
?>
<?php


if(isset($_GET['orderID2'])){
 $querystring='CALL _finnishedWorkOrder(:orderID,"1",NOW(),"logged by: '.$_SESSION['email'].'")';
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':orderID', $_GET['orderID2']);
 $stmt->execute();
 echo "Arbetsorder arkiverad";
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
          <th>Arkivera</th>
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
          echo "<td><a href='backend_wo.php?orderID=".$row['orderID']."'>Ta bort</a></td>";
          echo "<td><a href='backend_wo.php?orderID2=".$row['orderID']."'>logga</a></td>";
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
          foreach($pdo->query( 'SELECT * FROM wo where priority="akut" and entID="1" order by orderID desc;' ) as $row){
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

</table>
</div>




</div>
</div>
