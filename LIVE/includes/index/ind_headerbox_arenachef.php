<?php 
$a = 0;

foreach($pdo->query( 'select count(*)as a from wo;') as $row){
  $a = $row['a'];
}foreach($pdo->query( 'select count(*)as b from er;') as $row){
  $b = $row['b'];
}foreach($pdo->query( 'select count(*)as c from erSP;') as $row){
  $c = $row['c'];
}foreach($pdo->query( 'select count(*)as d from co;') as $row){
  $d = $row['d'];
}
?>

<div class="w3-row-padding w3-margin-bottom" style="cursor: pointer; cursor: hand;">  


  <div class="w3-quarter" style="cursor:pointer" onclick="MakeRequest('workorder');">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-green w3-padding-16">
      <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
      <div class="w3-right">
      <h3><?php print_r($a);?></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Aktiva arbetsordrar</h4>
    </div>
  </div>


  <div class="w3-quarter"style="cursor:pointer" onclick="MakeRequest('errorreport');">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-red w3-padding-16">
      <div class="w3-left"><i class="fa fa-exclamation-triangle  w3-xxxlarge"></i></div>
      <div class="w3-right">
      <h3><?php print_r($b);?></h3>
      </div>
      <div class="w3-clear" ></div>
      <h4>Nya felmeddelande</h4>
    </div>
  </div>

  <div class="w3-quarter" style="cursor:pointer" onclick="MakeRequest('report');">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-teal w3-padding-16">
      <div class="w3-left"><i class="fa fa-exchange w3-xxxlarge"></i></div>
      <div class="w3-right">
      <h3><?php print_r($c);?></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Rapporter och dagligt underhåll</h4>
    </div>
  </div>


  <div class="w3-quarter" style="cursor:pointer" onclick="MakeRequest('comments');">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-orange w3-text-white w3-padding-16">
      <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
      <div class="w3-right">
      <h3><?php print_r($d);?></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Kundkommentarer <b>(48h)</b></h4>
    </div>
  </div>


</div>