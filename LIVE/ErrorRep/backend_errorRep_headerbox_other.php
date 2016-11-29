<?php 
$i = 0;

    foreach($pdo->query( 'select count(*)as i from Error;') as $row){
        $i = $row['i'];
      }
       ?>

<header class="w3-container" style="padding-top:22px">
  <h4><b><i class="fa fa-dashboard"></i> Min kontrollpanel</b></h4>
</header>

<a href="./backend_report.php#13">
<div class="w3-third">
  <div class="w3-container w3-teal w3-padding-16">
    <div class="w3-left"><i class="fa fa-flag alt w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($i); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Sparade felanmälningar</h4>
  </div>
</div>
</a>


</div>