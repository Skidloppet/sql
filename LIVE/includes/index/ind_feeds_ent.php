
<?php
include '../connect.php'; 
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
                <th>Godkänn arbetsorder</th>
                <th>Information</th>
                <th>Arbetsorder-Typ</th>
                <th>Prioritet</th>
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
               echo "<td><button><i class='fa fa-check'></i> Acceptera</button> <<---(EJ KLAR)</td>";
               echo "<td>".$row['info']."</td>";
               echo "<td>".$row['type']."</td>";
               echo "<td>".$row['priority']."</td>";
               echo "<td>".$row['sentDate']."</td>";
               echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
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
    <h2 id="2">Mina arbetsordrar ( <?php echo $em?> )</h2>
    <table class="w3-table w3-striped w3-white">
      <tr>
        <td><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></td>
        <th>Information</th>
        <th>Arbetsorder-Typ</th>
        <th>Prioritet</th>
        <th>Datum skickad</th>
        <th>Skapad av</th>
        <th>Ange som verkställd</th>
      </tr>        
      <?php     

      foreach($pdo->query( "SELECT * FROM wo where email = '$em'") as $row){
        echo "<tr>";
        echo "<td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
        echo "<td>".$row['info']."</td>";
        echo "<td>".$row['type']."</td>";
        echo "<td>".$row['priority']."</td>";
        echo "<td>".$row['sentDate']."</td>";
        echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
        echo "<td><button><i class='fa fa-check'></i> Utförd</button> <<---(EJ KLAR)</td>";
        echo "</tr>";  
      }
      ?>   
    </table>
  </div>
</div></br>
