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
  <div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
    <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Meny</button>
    <span class="w3-right">Skidloppet AB</span>
  </div>

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



    <!-- ny ski roll -->
    <?php
    include'connect.php';
    ?>
    <div>
      <h3>Sätt ny roll för en Skidloppet användare</h3>
      <h4>fel när det inte finns någon av en viss typ(då försvinner alternativet)</h4>
      <form action='<?php $_PHP_SELF ?>' method='POST'>
        <select size='1' name='skiID'>
          <option selected="selected"> Choose employee </option>
          <?php    
          foreach($pdo->query( 'SELECT * FROM Ski ORDER BY skiID;' ) as $row){
            echo '<option value="'.$row['skiID'].'">';
            echo $row['firstName']." ".$row['lastName']." (".$row['type'].")";      
            echo '</option>';
          }    
          ?>
        </select>
        <select size='1' name='type'>
          <option selected="selected"> New role </option>
          <?php    
          foreach($pdo->query( 'SELECT type FROM Ski GROUP BY type;' ) as $row){
          # Denna bör ändras då den inte är fullt funktionell.
            echo '<option value="'.$row['type'].'">';
            echo $row['type'];      
            echo '</option>';
          }    
          ?>
        </select>
        <input type="submit" value="Send" name="send">
        <input type="reset">

        <?php 
        if(isset($_POST['send'])){
          $querystring='Call EditSki (:editSkiID, :newType);';
          $stmt = $pdo->prepare($querystring);
          $stmt->bindParam(':editSkiID', $_POST['skiID']);
          # select's name är skiID
          $stmt->bindParam(':newType', $_POST['type']);
          # select's name är type
          $stmt->execute();

  #uppdaterar sidan och visar nya lönen
        //  header("Location: hemsida5.php");
        }
        ?>
      </div>


      <!-- ny ent användare -->
      <div>
        <h3>Create new Ent</h3>
        <form action='<?php $_PHP_SELF ?>' method='POST'>
          <input type="text" name="firstName" placeholder="first name.."></p>
          <input type="text" name="lastName" placeholder="surname.."></p>
          <input type="text" name="email" placeholder="email.."></p>
          <input type="text" name="number" placeholder="number.."></p>
          <input type="password" name="pass" placeholder="password.."></p>
          <p><button type="submit" name="CreateEnt" id="CreateEnt">NEW ENT</button></p></form>


          <?php
             # skapa ett errormedelande vid fel input (email, number)

          if(isset($_POST['CreateEnt'])){

            $sql = "CALL CreateEnt(:pass, :firstName, :lastName ,:email, :number)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":pass", $_POST['pass'], PDO::PARAM_STR);
            $stmt->bindParam(":firstName", $_POST['firstName'], PDO::PARAM_STR);
            $stmt->bindParam(":lastName", $_POST['lastName'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
            $stmt->bindParam(":number", $_POST['number'], PDO::PARAM_INT);
            $stmt->execute();
          }     
          ?>
        </div>


        <!-- ny ski användare -->
        <div>
          <h3>Create new Ski</h3>
          <form action='<?php $_PHP_SELF ?>' method='POST'>
            <input type="text" name="firstName" placeholder="first name..">
            <input type="text" name="lastName" placeholder="surname..">
            <input type="text" name="email" placeholder="email..">
            <input type="text" name="number" placeholder="number..">
            <input type="text" name="type" placeholder="type..">
            <input type="text" name="pass" placeholder="password..">
            <button type="submit" name="CreateSki" id="CreateSki">NEW SKI</button>
          </form>


          <?php

          if(isset($_POST['CreateSki'])){

            $sql = "CALL CreateSki( :pass, :firstName, :lastName , :email, :number, :type)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":pass", $_POST['pass'], PDO::PARAM_STR);
            $stmt->bindParam(":firstName", $_POST['firstName'], PDO::PARAM_STR);
            $stmt->bindParam(":lastName", $_POST['lastName'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
            $stmt->bindParam(":number", $_POST['number'], PDO::PARAM_INT);
            $stmt->bindParam(":type", $_POST['type'], PDO::PARAM_STR);
            $stmt->execute();
          }     
          ?>
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
