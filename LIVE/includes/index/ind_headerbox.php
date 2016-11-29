<header class="w3-container" style="padding-top:22px">
   <!-- <h5><b><i class="fa fa-dashboard"></i> Min kontrollpanel</b></h5> -->
  </header>
<div class="w3-row-padding w3-margin-bottom">  
    
    
      <div class="w3-quarter">
       <a href="backend.php">
        <div class="w3-container w3-blue w3-padding-16">
          <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
          <div class="w3-right">
            <?php 
            $fråga = 0;
            $siffra = $fråga;
            echo '<h3> 666'.$siffra.'</h3>';
            ?>
          </div>
          <div class="w3-clear"></div>
          <h4>Arbetsordrar</h4>
        </div>
       </a>
      </div>
    

      <div class="w3-quarter">
       <a href="backend.php">
        <div class="w3-container w3-red w3-padding-16">
          <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
          <div class="w3-right">
            <?php 
            if (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {

              $sqlfråga = 0;
              $siffra = $sqlfråga;
              echo '<h3 style="background-color:black; padding-left:13px; height:45px; width:45px; border-radius: 70%;">11'.$siffra.'</h3>';
            }
            ?>
          </div>
          <div class="w3-clear" ></div>
          <h4 >Felmeddelanden</h4>
        </div>
       </a>
      </div>
    
    <div class="w3-quarter">
     <a href="backend.php">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>2</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Sträckor med fel</h4>
      </div>
     </a>
    </div>


    <div class="w3-quarter">
     <a href="backend.php">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>20</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Kundkommentarer idag</h4>
      </div>
     </a>
    </div>


</div>