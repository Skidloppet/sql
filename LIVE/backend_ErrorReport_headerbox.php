
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Min kontrollpanel</b></h5>
  </header>
<?php
  include 'connect.php';
?>
<?php 
$LiveErrors = 0;
      foreach($pdo->query( 'select * from Error;' ) as $row){
        $LiveErrors = $row['errorID'];


          /*if ($row['rating'] >= 4){
            $SubPlaceNameArray[$row['rspName']] = $green;
          }
          else if ($row['rating'] <= 2){
            $SubPlaceNameArray[$row['rspName']] = $red;
          }
          else if ($row['rating'] = 3){
            $SubPlaceNameArray[$row['rspName']] = $yellow;
          }
          else{
            $SubPlaceNameArray[$row['rspName']]= $grey;
          }
          */
      }
    ?>
  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-third">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
    <div class="w3-right">
          <h3><br></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Skapa ny felanm�lan</h4>
      </div>
    </div>
    <div class="w3-third">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-arrow-right w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php print_r($LiveErrors); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Existerande felanm�lningar</h4>
      </div>
    </div>
    <!--
    <div class="w3-third">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-flag alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>2</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Avslutade arbetsordrar</h4>
      </div>
    </div>
    -->

  </div>