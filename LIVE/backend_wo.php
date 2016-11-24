<!DOCTYPE html>
<?php
include'connect.php';
SESSION_START();
$id = $_SESSION['id'];

?>

<html>
<title>Skidloppet AB - Monitor</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="backend_style1.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">
<!--<link rel="stylesheet" href="style3.css">-->
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

  <!-- Top container -->
  <div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
    <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Meny</button>
    <span class="w3-right">Skidloppet AB</span>
  </div>

  <!-- Sidenav/menu -->
  <?php
  include 'backend_sidemenu.php';
  ?>


  <!-- Overlay effect when opening sidenav on small screens -->
  <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay">
  </div>

  <!-- !PAGE CONTENT! -->
  <div class="w3-main" style="margin-left:300px;margin-top:43px;">





    <?php
    if (!isset($_SESSION['email'])) {
      ?>
      <a href="Kund.php">
        <h3>logga in</h3>
      </a>
      <?php 
    } 
    elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {

      include 'wo/backend_wo_headerbox_arenachef.php';
      ?>
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'wo/backend_wo_feeds_arenachef.php';
          }
          elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'other')) {

      include 'wo/backend_wo_headerbox_other.php';
      ?>
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'wo/backend_wo_feeds_other.php';
          }
          elseif (isset($_SESSION['email'])&&($_SESSION['type'] > '1')) {

      include 'wo/backend_wo_headerbox_ent.php';
      ?>
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'wo/backend_wo_feeds_ent.php';
          }
          else{
            echo "if this message is showing your logged in as a hacker or smt";
          }
          










          if(isset($_GET['akutOrderID'])){
          $querystring='call _akut (:_orderID, :_EM);';
          $stmt = $pdo->prepare($querystring);
          $stmt->bindParam(':_orderID', $_GET['akutOrderID']);
          $stmt->bindParam(':_EM', $em);
          $stmt->execute();
          echo "akut order uppdaterad";
        }

        ?>
      </div>
      <hr>






        <!-- spara?
        
        <div class="w3-container">
          <h5>Recent Users</h5>
          <ul class="w3-ul w3-card-4 w3-white">
            <li class="w3-padding-16">
              <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>
              <img src="/w3images/avatar2.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
              <span class="w3-xlarge">Mike</span><br>
            </li>
            <li class="w3-padding-16">
              <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>
              <img src="/w3images/avatar5.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
              <span class="w3-xlarge">Jill</span><br>
            </li>
            <li class="w3-padding-16">
              <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>
              <img src="/w3images/avatar6.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
              <span class="w3-xlarge">Jane</span><br>
            </li>
          </ul>
        </div>
        <hr>
      -->

  

        <!-- Footer -->
        <footer class="w3-container w3-padding-16 w3-light-grey">
          <h4>FOOTER</h4>
          <p>Powered by <a href="http://www.his.se" target="_blank">SLITAB</a></p>
        </footer>

        <!-- End page content -->
      </div>
    </div>
  </div>

  <script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
  if (mySidenav.style.display === 'block') {
    mySidenav.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidenav.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidenav with the close button
function w3_close() {
  mySidenav.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>
