<?php 
$i = 0;
$i2 = 0;

    foreach($pdo->query( 'select count(*)as i from Error;') as $row){
        $i = $row['i'];
      }
       ?>

<header class="w3-container" style="padding-top:22px">
  <style>
.HoverButton:hover { background: Red; }
.HoverButton2:hover { background: Green; }
  </style>
</header>

<a href="#12">
<div class="w3-third">
  <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-blue w3-padding-16">
    <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($i); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Aktuella felanmälningar</h4>
  </div>
</div>
</a>

</div>