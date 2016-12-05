<?php 
$i = 0;
$i2 = 0;

foreach($pdo->query( 'select count(*)as i from wo;') as $row){
  $i = $row['i'];
}
foreach($pdo->query( 'select count(*)as i2 from fwo;' ) as $row){
  $i2 = $row['i2'];
}

foreach($pdo->query( 'select count(*)as b from er;') as $row){
  $b = $row['b'];
}
?>


<div class="w3-row-padding w3-margin-bottom">

  <div class="w3-quarter" style="cursor:pointer" onclick="MakeRequest('errorreport');">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-red w3-padding-16">
      <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
      <div class="w3-right">
      <h3><?php print_r($b);?></h3>
      </div>
      <div class="w3-clear" ></div>
      <h4>Felmeddelanden</h4>
    </div>
  </div>

    <div class="w3-quarter" style="cursor:pointer" onclick="MakeRequest('report');">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-teal w3-padding-16">
      <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
      <div class="w3-right">
      <h3>x</h3>
      </div>
      <div class="w3-clear" ></div>
      <h4>Rapporter</h4>
    </div>
  </div>

</div>