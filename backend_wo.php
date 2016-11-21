<!DOCTYPE html>
<!--
Kommentarer:
stängde 2 div taggar som var öppna

-->

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

    <!-- Header -->
    <?php
    include 'wo/backend_wo_headerbox.php';
    ?>

    <div class="w3-container w3-section">
      <div class="w3-row-padding" style="margin:0 -16px">

        <div class="w3-threethird">
          <?php
          include 'wo/backend_wo_feeds.php';
          ?>
        </div>
        <hr>

<!--
Ny arbetsorder!
förbättringsmöjligheter:
alt. skapa json som tar bort input 'entID' om man kör split
skapa dropdown alternativ för prio & type? (går att fixa en php funktion man kan skapa för att hantera alla ENUM dropdown (återanvändningsbar kod för FLERA enum inputs))
-->

<?php
include'connect.php';
#include './backend_connect.php';
?>
<div class="w3-container">
  <h3>Add a new workorder</h3>
  <form action='backend_wo.php' method='POST'>
    <input type="text" name="SkiID" placeholder="SkiID..(session)"></p>
    <input type="text" name="Prioritering" placeholder="Prioritering..(low,akut)"></p>
    <input type="text" name="type" placeholder="type (tracks, trees osv.)"></p>
    <input type="text" name="Info" placeholder="Info.."></p>
    <input type="checkbox" name="split" value="1">split order for each track 'owner' <br>
    <input type="text" name="EntID" placeholder="EntID.."></p>
    <input type="text" name="Start" placeholder="Start.."></p>
    <input type="text" name="Slut" placeholder="Slut.."></p>
    <p><button type="submit" name="_newSplitWorkOrder" id="_newWorkOrder">NEW Report</button></p></form>


    <?php

    if(isset($_POST['_newSplitWorkOrder'])){

      $sql = "CALL _newSplitWorkOrder(:newSkiID, :newEntID, NOW() ,:newPriority, :newType, :newInfo, :newSplit, :startName, :endName)";

      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":newSkiID", $_POST['SkiID'], PDO::PARAM_INT);
      $stmt->bindParam(":newEntID", $_POST['EntID'], PDO::PARAM_INT);
      $stmt->bindParam(":newPriority", $_POST['Prioritering'], PDO::PARAM_STR);
      $stmt->bindParam(":newType", $_POST['type'], PDO::PARAM_STR);
      $stmt->bindParam(":newInfo", $_POST['Info'], PDO::PARAM_STR);
      $stmt->bindParam(":newSplit", $_POST['split'], PDO::PARAM_INT);
      $stmt->bindParam(":startName", $_POST['Start'], PDO::PARAM_INT);
      $stmt->bindParam(":endName", $_POST['Slut'], PDO::PARAM_INT);
      $stmt->execute();
    }

    ?>
  </div>


  <div class="w3-container">
    <h5>Snittbetygen på hela arenan</h5>
    <?php

    foreach($pdo->query( 'SELECT * FROM snittBetyg, snitt;' ) as $row){

      # kolla VIEW snittBetyg & snitt
      # lade till B tagg för att göra snittet enklare att se (row r,u,e,g /5)

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

      echo '  <p>Spårkanter</p>';
      echo ' <div class="w3-progress-container w3-grey">';
      echo '  <div id="myBar" class="w3-progressbar w3-orange" style="width:'.$row["edge"].'%">';
      echo '    <div class="w3-center w3-text-white"><b>'.$row["e"].'/5</b></div>';
      echo '   </div>';
      echo ' </div>';

      echo ' <p>Stavfäste</p>';
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
    <h5>Entrepenörernas nästa planerade arbetspass</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <tr>
        <th>Name</th>
        <th>latest shift</th>
        <th>next planned</th>
      </tr>
      <?php
    # kolla procedur entWork...
      foreach($pdo->query( 'SELECT * FROM entWork;' ) as $row){

        echo ' <tr>';
        echo ' <td>'.$row["firstName"].' '.$row["lastName"].'</td>';
        echo ' <td>'.$row["startDate"].'</td>';
        echo ' <td>'.$row["date"].'</td>';
        echo ' </tr>';
      }

      ?>
    </table><br>
    <button class="w3-btn">Könstig knäpp  <i class="fa fa-arrow-right"></i></button>
  </div>



  <div class="w3-container w3-blue">
    <h3>Ändra ansvar för en arbetsorder till ny entrepenör</h3>
    <form action='<?php $_PHP_SELF ?>' method='POST'>
      <select name="entID">
        <option>Entrepenörer</option>
        <?php    
        foreach($pdo->query( 'SELECT * FROM Ent; ' ) as $row){
          echo '<option value="'.$row['entID'].'">';
          echo $row['firstName']." ".$row['lastName']." (".$row['entID'].")";      
          echo '</option>'; } ?> 
        </select> 
        <select name="orderID">
          <option >Arbetsorder ID</option>
          <?php    
          foreach($pdo->query( 'SELECT * FROM WorkOrder; ' ) as $row){
            echo '<option value="'.$row['orderID'].'">';
            echo $row['orderID'];      
            echo '</option>'; } ?> 
          </select>     
          <button type="submit" name="send">BYT</button></form>


          <?php

          if(isset($_POST['send'])){
            $sql = "call _newResponsability (:_entID,:_orderID)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":_entID", $_POST['entID'], PDO::PARAM_INT);
            $stmt->bindParam(":_orderID", $_POST['orderID'], PDO::PARAM_INT);
            $stmt->execute();

            # DEN UPPDATERAR INTE LISTAN OVAN (endast om man laddar om sidan..)
            header("refresh: 3;");
          }    
          ?>
          <hr>
        </div>


        <!-- lite mellanrum bara XD -->
        <hr><hr><hr><hr><hr><hr><hr><hr><hr><hr>
        <hr><hr><hr><hr><hr><hr><hr><hr><hr><hr>
        <hr><hr><hr><hr><hr><hr><hr><hr><hr><hr>
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
