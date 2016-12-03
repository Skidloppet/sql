<?php 
$LiveOrders = 0;
$LiveOrders2 = 0;

      foreach($pdo->query( 'select * from WorkOrder, Ent where WorkOrder.entID=Ent.entID and Ent.entID = '.$_SESSION['id'].';' ) as $row){
        $LiveOrders = $row['orderID'];
      }
      foreach($pdo->query( 'select * from FinnishedWorkOrder, Ent where FinnishedWorkOrder.entID=Ent.entID and Ent.entID = '.$_SESSION['id'].';' ) as $row){
        $LiveOrders2 = $row['orderID'];
      }
       ?>



<a href="./backend_wo.php#1">
<div class="w3-row-padding w3-margin-bottom">
  <div class="w3-third">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-red w3-padding-16">
      <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3>X</h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Skapa ny arbetsorder</h4>
    </div>
  </div>
</a>


<a href="./backend_wo.php#2">
<div class="w3-third">
  <div class=" w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-blue w3-padding-16">
    <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($LiveOrders); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Pågående arbetsordrar</h4>
  </div>
</div>
</a>



<a href="./backend_wo.php#3">
<div class="w3-third">
  <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-teal w3-padding-16">
    <div class="w3-left"><i class="fa fa-flag alt w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($LiveOrders2); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Avslutade arbetsordrar</h4>
  </div>
</div>
</a>


</div>