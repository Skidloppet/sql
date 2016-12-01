<?php
session_start();
include 'connect.php';
?>
  <!-- Top container -->
  <div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
    <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Meny</button>
    <span class="w3-right">Skidloppet AB</span>
    <?php
        if (isset($_SESSION['email'])){
    ?>
            <button class="w3-right w3-margin-right w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="logout.php"><i class="fa fa-unlock"></i>  Logga ut</button>
    <?php 
        }
        else {
            $url = htmlspecialchars($_GET['url']);
            header( 'Refresh: 0; url=./Kund.php'.$url );
        }
    ?>
  </div>
<!-- Sidenav/menu -->
<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8">
      <span>Välkommen,<br> 
        <strong>
          <?php 
          $em = $_SESSION['email'];
          foreach($pdo->query("SELECT * FROM AllUsers WHERE email = '$em'") as $row){
            echo $row['firstName']." ".$row['lastName'];      
          }
          ?>
        </strong>
      </span>
      <br>
      <a href="logout.php" class="w3-hover-none w3-hover-text-red w3-show-inline-block"><i class="fa fa-unlock"></i> Logga ut</a>
    </div>
  </div>
  <hr>

  <div class="w3-container">
    <h5>Meny</h5>
  </div>
  <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Stäng meny</a>
<?php   ?>

  <?php
  if (!isset($_SESSION['email'])) {
    ?>
    <a href="Kund.php" >"><i class="fa fa-dashboard fa-fw"></i>  Ej inloggad - Kund.php</a>
    <?php
  }
  else {
    ?>
    <a href="#" data-content="index" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_index.php') {echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; }?>"><i class="fa fa-dashboard fa-fw"></i>  Översikt</a>
    <a href="#" data-content="report" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_report.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-history fa-fw"></i>  Rapportera</a>
    <a href="#" data-content="workorder" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'workorder.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-eye fa-fw"></i>  Arbetsordrar</a>
    <a href="#" data-content="errorreport" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_ErrorReport.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-comment fa-fw"></i>  Felanmälan</a>
    <a href="#" data-content="archive" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_ark.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-history fa-fw"></i>  Arkiv</a>
    <a href=""><?php   echo basename($_SERVER['SCRIPT_NAME']); ?></a>
    <?php

  } 
  if (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {
    ?>
    <a href="#" data-content="comments" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_kom.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-users fa-fw"></i>  Kundkommentarer</a>
    <a href="#" data-content="settings" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_ins.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-cog fa-fw"></i>  Inställningar</a>
    <a href="#" data-content="users" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_anv.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-user fa-fw"></i>  Användaradministration</a>
	    <a href="#" data-content="subplace" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_stra.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-share-alt fa-fw"></i>  Sträckor</a>
  <a href="#" data-content="cannons" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_cannon.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-asterisk fa-fw"></i>  Snökanoner</a><br><br>
    <?php   
  }
  elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'other')) {
    ?>
    <a href="#" data-content="comments" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_kom.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-users fa-fw"></i>  Kundkommentarer</a>
    <?php 
  }
  ?>

</nav>



<!--
  <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Stäng meny</a>
  <a href="backend_index.php" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_index.php') {echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; }?>"><i class="fa fa-dashboard fa-fw"></i>  �versikt</a>
  <a href="backend_wo.php" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_wo.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-eye fa-fw"></i>  Arbetsordrar</a>
  <a href="backend_fel.php" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_fel.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-comment fa-fw"></i>  Felanm�lan</a>
  <a href="backend_kom.php" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_kom.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-users fa-fw"></i>  Kundkommentarer</a>
  <a href="backend_stra.php" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_stra.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-share-alt fa-fw"></i>  Str�ckor</a>
  <a href="backend_ark.php" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_ark.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-history fa-fw"></i>  Arkiv</a>
  <a href="backend_ins.php" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_ins.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-cog fa-fw"></i>  Inst�llningar</a>
  <a href="backend_anv.php" class="<?php if(basename($_SERVER['SCRIPT_NAME']) == 'backend_anv.php'){echo 'w3-padding w3-blue'; }else { echo 'w3-padding'; } ?>"><i class="fa fa-user fa-fw"></i>  Anv�ndaradministration</a><br><br>
</nav>

  -->
