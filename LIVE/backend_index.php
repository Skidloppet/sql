
<?php
SESSION_START();
?>
<!DOCTYPE html>
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
 

      <!-- Sidenav/menu -->
      <?php
      include 'backend_sidemenu.php';
      ?>


      <!-- Overlay effect when opening sidenav on small screens -->
      <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

      <!-- !PAGE CONTENT! -->
      <div class="w3-main" style="margin-left:300px;margin-top:43px;">

        <!-- Header -->
        <?php
        include 'backend_headerbox.php';
        ?>

        <div class="w3-container w3-section">
          <div class="w3-row-padding" style="margin:0 -16px">
            <div class="w3-threethird">
              <?php
              include 'backend_map.php';
              ?>
            </div>

            <div class="w3-threethird">
              <?php
              include 'backend_dsstatus.php';
              ?>
            </div>

            <div class="w3-threethird">
              <?php
              include 'backend_feeds.php';
              ?>
            </div>
          </div>
        </div>
            <hr>











  <div class="w3-container">
    <h5>Snittbetygen p� hela arenan</h5>
    <?php

    foreach($pdo->query( 'SELECT * FROM snittBetyg, snitt;' ) as $row){

      # kolla VIEW snittBetyg & snitt
      # lade till B tagg f�r att g�ra snittet enklare att se (row r,u,e,g /5)

      echo '<p>Rating</p>';
      echo '<div class="w3-progress-container w3-grey">';

      echo '<div id="myBar" class="w3-progressbar w3-blue" style="width:'.$row["rat"].'%">';
      echo '<div class="w3-center w3-text-white"><b>'.$row["r"].'/5</b></div>';
      echo 'echo   </div>';
      echo ' </div>';
      echo '   <p>Underlag</p>';
      echo ' <div class="w3-progress-container w3-grey">';

      echo '  <div id="myBar" class="w3-progressbar w3-red" style="width:'.$row["under"].'%">';
      echo '   <div class="w3-center w3-text-white"><b>'.$row["u"].'/5</b></div>';
      echo '   </div>';
      echo ' </div>';

      echo '  <p>Sp�rkanter</p>';
      echo ' <div class="w3-progress-container w3-grey">';
      echo '  <div id="myBar" class="w3-progressbar w3-orange" style="width:'.$row["edge"].'%">';
      echo '    <div class="w3-center w3-text-white"><b>'.$row["e"].'/5</b></div>';
      echo '   </div>';
      echo ' </div>';

      echo ' <p>Stavf�ste</p>';
      echo '<div class="w3-progress-container w3-grey">';
      echo ' <div id="myBar" class="w3-progressbar w3-green" style="width:'.$row["grip"].'%">';
      echo '    <div class="w3-center w3-text-white"><b>'.$row["g"].'/5</b></div>';
      echo '  </div>';
      echo ' </div>';

    }
    ?>
  </div>
  <hr>






        

            <div class="w3-container">
              <h5>Countries</h5>
              <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                <tr>
                  <td>United States</td>
                  <td>65%</td>
                </tr>
                <tr>
                  <td>UK</td>
                  <td>15.7%</td>
                </tr>
                <tr>
                  <td>Russia</td>
                  <td>5.6%</td>
                </tr>
                <tr>
                  <td>Spain</td>
                  <td>2.1%</td>
                </tr>
                <tr>
                  <td>India</td>
                  <td>1.9%</td>
                </tr>
                <tr>
                  <td>France</td>
                  <td>1.5%</td>
                </tr>
              </table><br>
              <button class="w3-btn">More Countries  <i class="fa fa-arrow-right"></i></button>
            </div>
            <hr>
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

            <div class="w3-container">
              <h5>Senaste kommentarerna</h5>
              <div class="w3-row">
                <div class="w3-col m2 text-center">
                  <img class="w3-circle" src="/w3images/avatar3.png" style="width:96px;height:96px">
                </div>
                <div class="w3-col m10 w3-container">
                  <h4>Kund <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
                  <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
                </div>
              </div>

              <div class="w3-row">
                <div class="w3-col m2 text-center">
                  <img class="w3-circle" src="/w3images/avatar1.png" style="width:96px;height:96px">
                </div>
                <div class="w3-col m10 w3-container">
                  <h4>Jonas <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
                  <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
                </div>
              </div>
            </div>
            <br>
            <div class="w3-container w3-dark-grey w3-padding-32">
              <div class="w3-row">
                <div class="w3-container w3-third">
                  <h5 class="w3-bottombar w3-border-green">Demographic</h5>
                  <p>Language</p>
                  <p>Country</p>
                  <p>City</p>
                </div>
                <div class="w3-container w3-third">
                  <h5 class="w3-bottombar w3-border-red">System</h5>
                  <p>Browser</p>
                  <p>OS</p>
                  <p>More</p>
                </div>
                <div class="w3-container w3-third">
                  <h5 class="w3-bottombar w3-border-orange">Target</h5>
                  <p>Users</p>
                  <p>Active</p>
                  <p>Geo</p>
                  <p>Interests</p>
                </div>
              </div>
            </div>

            <!-- Footer -->
            <footer class="w3-container w3-padding-16 w3-light-grey">
              <h4>FOOTER</h4>
              <p>Powered by <a href="http://www.his.se" target="_blank">SLITAB</a></p>
            </footer>

            <!-- End page content -->
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
