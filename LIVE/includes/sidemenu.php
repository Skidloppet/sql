<?php
session_start();
include 'connect.php';
?>
<!-- Top container -->
<div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
  <button class="w3-btn w3-hide-large w3-padding-0 " onclick="w3_open();"><i class="fa fa-bars"></i>  Meny</button>
  <span class="w3-right">Skidloppet AB</span>
  <?php
  if (isset($_SESSION['email'])){
    ?>
	<button class="w3-right w3-margin-right w3-btn w3-large w3-padding-0 " onclick="logout.php"><i class="fa fa-unlock"></i>  Logga ut</button>
	
	<button class="w3-right w3-margin-right w3-btn w3-large w3-padding-0 " onclick="Kund.php"><i class="fa fa-home"></i></button>

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
      <img src="user.png" alt="profilbild" class=" w3-margin-right" style="width:46px">
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
      <a href="Kund.php" class="w3-hover-none w3-hover-text-red w3-show-inline-block"><i class="fa fa-home"></i> Kundvy</a>
    </div>
  </div>
  <hr>

  <div class="w3-container">
    <h4>Meny</h4>
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
    <a href="#" onclick="MakeRequest('index');" class="w3-padding w3-black"><i class="fa fa-dashboard fa-fw"></i>  Översikt</a>
    <a href="#" onclick="MakeRequest('report');" class="w3-padding w3-teal"><i class="fa fa-dashboard fa-fw"></i>  Rapportera</a>
    <a href="#" onclick="MakeRequest('workorder');" class="w3-padding w3-green"><i class="fa fa-eye fa-fw"></i>  Arbetsordrar</a>
    <a href="#" onclick="MakeRequest('errorreport');" class="w3-padding w3-red"><i class="fa fa-comment fa-fw"></i>  Felanmälan</a>
    <a href="#" onclick="MakeRequest('comments');" class="w3-padding w3-orange"><i class="fa fa-users fa-fw"></i>  Kundkommentarer</a>
    <?php

  } 
  if (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {
    ?>
    <a href="#" onclick="MakeRequest('users');" class="w3-padding w3-indigo"><i class="fa fa-user fa-fw"></i>  Användaradministration</a>
    <a href="#" onclick="MakeRequest('subplace');" class="w3-padding w3-cyan"><i class="fa fa-share-alt fa-fw"></i>  Sträckor</a>
    <a href="#" onclick="MakeRequest('cannons');" class="w3-padding w3-brown"><i class="fa fa-asterisk fa-fw"></i>  Snökanoner</a><br><br>
    <?php   
  }
  elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'other')) {
    ?>
    <?php 
  }
  ?>

</nav>
