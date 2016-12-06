<?php 
$i = 0;

foreach($pdo->query( 'select count(*)as i from Error;') as $row){
  $i = $row['i'];
}
?>

<div class="w3-container" style="padding-left:20px">
  <div class="w3-row-padding w3-margin-bottom">

  <a href="#12">
    <div class="w3-quarter">
      <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php print_r($i); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Aktuella felanmälningar</h4>
      </div>
    </div>
  </a>

</div></div>