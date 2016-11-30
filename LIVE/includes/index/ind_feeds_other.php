
<?php
include '../connect.php';	
?>	

<?php

if(isset($_GET['orderID'])){
 $querystring='DELETE FROM WorkOrder WHERE orderID = :orderID';
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':orderID', $_GET['orderID'], PDO::PARAM_INT);
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

<?php
$akut = 0;
foreach($pdo->query( 'SELECT count(*) as nmr FROM wo where priority="akut" and entID="1";' ) as $row){
  $akut = $row['nmr'];
  if (0 < $akut){
    ?>
    <div class="w3-container w3-orange" style="border-color:lightblue; border-style: solid; border-width: 5px;">
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <h1><b>Akuta arbetsordrar</b></h1>
            <table class="w3-table w3-striped w3-white">
              <tr>
                <td><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></td>
                <th>Order ID</th>
                <th>Arbetsorder-Typ</th>
                <th>Prioritet</th>
                <th>Information</th>
                <th>Datum skickad</th>
                <th>Skapad av</th>
              </tr> 

              <?php     
        # hämtar alla aktiva arbetsordrar(WorkOrder) som tillhör det autoangivna akutID (#1)
        # hemsidan visar entrepenörens förnamn och enfternamn genom kopplingen mellan
              foreach($pdo->query( 'SELECT * FROM wo where priority="akut" and entID="1" order by orderID desc;' ) as $row){

               echo"      <form action='backend.php' method='POST'>       ";
               echo "<tr>";
               echo "<td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
               echo "<td name='orderID'>".$row['orderID']."</td>";
               echo "<td>".$row['type']."</td>";
               echo "<td>".$row['priority']."</td>";
               echo "<td>".$row['info']."</td>";
               echo "<td>".$row['sentDate']."</td>";
               echo "<td>".$row['entF']." ".$row['entL']." ( ".$row['entID']." )</td>";
               echo "</tr>";  
          }

          ?>   
        </form>
      </table>
    </div>
  </div>
</div>
</div>

<?php
}
}
?>

<h2>Översikt</h2>

<div  class="w3-threethird" style="border-color:lightblue; border-style: solid; border-width: 5px;">
  <?php
  include './map.php';
  ?>
</div>
</div>
</div>

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

<div class="w3-row-padding" style="border-color:lightblue; border-style: solid; border-width: 5px;">
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


<div class="w3-row-padding" style="border-color:lightblue; border-style: solid; border-width: 5px; margin-top:15px;">
  <div class="w3-threethird">
    <h5>Senaste avklarade rapporterna (max 5)</h5>
    <table class="w3-table w3-striped w3-white">
      <tr>
        <th><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></th>
        <th>Report-ID</th>
        <th>Entrepenör</th>
        <th>Avklarad</th>
        <th>Nästa planerade pass</th>
        <th>Betyg</th>
        <th>Underlag</th>
        <th>Spårkanter</th>
        <th>Stavfäste</th>
        <th>Snödjup</th>
        <th>Kommentar</th>
        <th>Spårade delsträckor</th>
      </tr>        
      <?php     

      foreach($pdo->query( 'select * from storedR;' ) as $row){
        echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
        echo "<td>".$row['reportID']."</td>";
        echo "<td>".$row['firstName']." ".$row['lastName']." ( ".$row['entID']." )</td>";
        echo "<td>".$row['startDate']."</td>";
        echo "<td>".$row['workDate']."</td>";
        echo "<td>".$row['rating']."</td>";
        echo "<td>".$row['underlay']."</td>";
        echo "<td>".$row['edges']."</td>";
        echo "<td>".$row['grip']."</td>";
        echo "<td>".$row['depth']."</td>";
        echo "<td>".$row['comment']."</td>";
        echo "<td>tom..foreach alla N:M</td>";
        echo "</tr>";  
      }
      ?>   
       </table>
  </div>

</div>

