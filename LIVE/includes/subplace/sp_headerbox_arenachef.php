<?php 
$i = 0;
$i2 = 0;

      foreach($pdo->query( 'select count(*)as i from Report;') as $row){
        $i = $row['i'];
      }
       ?>

<header class="w3-container" style="padding-top:22px">
  <style>
.HoverButton:hover { background: Red; }
.HoverButton2:hover { background: Green; }
  </style>
</header>

<a href="#11">
<div class="w3-row-padding w3-margin-bottom">
  <div class="w3-third">
    <div class="w3-container w3-red w3-padding-16">
      <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3>X</h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Alla delsträckor</h4>
    </div>
  </div>
</a>


<a href="./backend_report.php#12">
<div class="w3-third">
  <div class="w3-container w3-blue w3-padding-16">
    <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($i); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Aktuella rapporter</h4>
  </div>
</div>
</a>



<a href="./backend_report.php#13">
<div class="w3-third">
  <div class="w3-container w3-teal w3-padding-16">
    <div class="w3-left"><i class="fa fa-flag alt w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><?php print_r($i2); ?></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Avslutade arbetsordrar</h4>
  </div>
</div>
</a>


</div>