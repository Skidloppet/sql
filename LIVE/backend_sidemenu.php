<<<<<<< HEAD
<?php
SESSION_START();
include 'connect.php';
?>


<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8">
      <span>Välkommen, <strong><table>
        <?php 
        $em = $_SESSION['email'];
   foreach($pdo->query("SELECT * FROM AllUsers WHERE email = '$em'") as $row){
      echo $row['firstName']." ".$row['lastName'];      
      }

      ?>
           </table></strong></span><br>
      <a href="#" class="w3-hover-none w3-hover-text-red w3-show-inline-block"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-hover-none w3-hover-text-green w3-show-inline-block"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Meny</h5>
  </div>
  <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Stäng meny</a>
  <a href="backend_index.php" class="w3-padding w3-blue"><i class="fa fa-dashboard fa-fw"></i>  Översikt</a>
  <a href="backend_wo.php" class="w3-padding"><i class="fa fa-eye fa-fw"></i>  Arbetsordrar</a>
  <a href="#" class="w3-padding"><i class="fa fa-comment fa-fw"></i>  Felanmälan</a>
  <a href="#" class="w3-padding"><i class="fa fa-users fa-fw"></i>  Kundkommentarer</a>
  <a href="#" class="w3-padding"><i class="fa fa-share-alt fa-fw"></i>  Sträckor</a>
  <a href="#" class="w3-padding"><i class="fa fa-history fa-fw"></i>  Arkiv</a>
  <a href="#" class="w3-padding"><i class="fa fa-cog fa-fw"></i>  Inställningar</a>
  <a href="#" class="w3-padding"><i class="fa fa-user fa-fw"></i>  Användaradministration</a><br><br>
=======
<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8">
      <span>Välkommen, <strong>Tomas</strong></span><br>
      <a href="#" class="w3-hover-none w3-hover-text-red w3-show-inline-block"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-hover-none w3-hover-text-green w3-show-inline-block"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Meny</h5>
  </div>
  <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Stäng meny</a>
  <a href="backend_index.php" class="w3-padding w3-blue"><i class="fa fa-dashboard fa-fw"></i>  Översikt</a>
  <a href="backend_wo.php" class="w3-padding"><i class="fa fa-eye fa-fw"></i>  Arbetsordrar</a>
  <a href="backend_fel.php" class="w3-padding"><i class="fa fa-comment fa-fw"></i>  Felanmälan</a>
  <a href="backend_kom.php" class="w3-padding"><i class="fa fa-users fa-fw"></i>  Kundkommentarer</a>
  <a href="backend_stra.php" class="w3-padding"><i class="fa fa-share-alt fa-fw"></i>  Sträckor</a>
  <a href="backend_ark.php" class="w3-padding"><i class="fa fa-history fa-fw"></i>  Arkiv</a>
  <a href="backend_ins.php" class="w3-padding"><i class="fa fa-cog fa-fw"></i>  Inställningar</a>
  <a href="backend_anv.php" class="w3-padding"><i class="fa fa-user fa-fw"></i>  Användaradministration</a><br><br>
>>>>>>> 4c1e661a9e178084a9da6a4ed0032d83f34ef94c
</nav>