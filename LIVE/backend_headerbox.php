      <a href="backend_wo.php">
      <div class="w3-quarter">
        <div class="w3-container w3-blue w3-padding-16">
          <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
          <div class="w3-right">
            <?php 
            $fr�ga = 0;
            $siffra = $fr�ga;
            echo '<h3> 666'.$siffra.'</h3>';
            ?>
          </div>
          <div class="w3-clear"></div>
          <h4>Arbetsordrar</h4>
        </div>
      </div>
    </a>

    <a href="backend_ErrorReport.php">
      <div class="w3-quarter">
        <div class="w3-container w3-red w3-padding-16">
          <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
          <div class="w3-right">
            <?php 
            if (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {

              $sqlfr�ga = 0;
              $siffra = $sqlfr�ga;
              echo '<h3 style="background-color:black; padding-left:13px; height:45px; width:45px; border-radius: 70%;">11'.$siffra.'</h3>';
            }
            ?>
          </div>
          <div class="w3-clear" ></div>
          <h4 >Felmeddelanden</h4>
        </div>
      </div>
    </a>

<a href="backend_stra.php">
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>2</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Str�ckor med fel</h4>
      </div>
    </div>
</a>
<a href="backend_kom.php">
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>20</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Kundkommentarer idag</h4>
      </div>
    </div>
</a>