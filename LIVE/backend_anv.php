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


    <!-- utskrift SKI -->
<div class="w3-container w3-right w3-purple w3-large w3-padding" style="z-index:4">  <h3>Utskrift av Skidloppet-anst�llde</h3>
    <table>
      <?php   
          echo "<tr>";
            echo "<th>skiID</th>"; 
            echo "<th>FirstName</th>"; 
            echo "<th>LastName</th>"; 
            echo "<th>emailadress</th>"; 
            echo "<th>type</th>"; 
            echo "<th>tel-number</th>"; 
            echo "<th>password</th>"; 
            echo "<th>regDate</th>"; 

            echo "</tr>";
          foreach($pdo->query( 'SELECT * FROM Ski;' ) as $row){
            //echo "<tr><td>";
            //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
            echo "<tr>";
            echo "<td>".$row['entID']."</td>";
            echo "<td>".$row['firstName']."</td>";
            echo "<td>".$row['lastName']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['type']."</td>";
            echo "<td>".$row['number']."</td>";
            echo "<td>".$row['password']."</td>";
            echo "<td>".$row['regDate']."</td>";
            echo "</tr>";  
        }
        ?>
      </table>
</div>
    <!-- utskrift ent -->
<div class="w3-container w3-right w3-pink w3-large" style="z-index:4">  <h3>Utskrift av feta entrepren�rer</h3>
    <table>
      <?php   
          echo "<tr>";
            echo "<th>entID</th>"; 
            echo "<th>FirstName</th>"; 
            echo "<th>LastName</th>"; 
            echo "<th>emailadress</th>"; 
            echo "<th>tel-number</th>"; 
            echo "<th>password</th>"; 
            echo "<th>regDate</th>"; 

            echo "</tr>";
          foreach($pdo->query( 'SELECT * FROM Ent;' ) as $row){
            //echo "<tr><td>";
            //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
            echo "<tr>";
            echo "<td>".$row['entID']."</td>";
            echo "<td>".$row['firstName']."</td>";
            echo "<td>".$row['lastName']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['number']."</td>";
            echo "<td>".$row['password']."</td>";
            echo "<td>".$row['regDate']."</td>";
            echo "</tr>";  
        }
        ?>
      </table>
</div>





    <!-- ny ski roll -->
    <?php
    include'connect.php';
    ?>
    <div class="w3-green">
      <h3>S�tt ny roll f�r en Skidloppet anv�ndare</h3>
      <h4>fel n�r det inte finns n�gon av en viss typ(d� f�rsvinner alternativet)</h4>
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
          # Denna b�r �ndras d� den inte �r fullt funktionell.
            echo '<option value="'.$row['type'].'">';
            echo $row['type'];      
            echo '</option>';
          }    
          ?>
        </select>
        <input type="submit" value="Send" name="send">
        <input type="reset">
        </form>

        <?php 
        if(isset($_POST['send'])){
          $querystring='Call EditSki (:editSkiID, :newType);';
          $stmt = $pdo->prepare($querystring);
          $stmt->bindParam(':editSkiID', $_POST['skiID']);
          # select's name �r skiID
          $stmt->bindParam(':newType', $_POST['type']);
          # select's name �r type
          $stmt->execute();

  #uppdaterar sidan och visar nya l�nen
        //  header("Location: hemsida5.php");
        }
        ?>
      </div>




       <div class ="w3-cyan w3-container-small w3-border-radius">
      <h3>S�tt nytt tel-nummer f�r en entrepren�r anv�ndare</h3>
      <form action='<?php $_PHP_SELF ?>' method='POST'>
        <select size='1' name='entID'>
          <option selected="selected"> v�lj entrepren�r </option>
          <?php    
          foreach($pdo->query( 'SELECT * FROM Ent ORDER BY entID;' ) as $row){
            echo '<option value="'.$row['entID'].'">';
            echo $row['firstName']." ".$row['lastName']." (".$row['number'].")";      
            echo '</option>';
          }    
          ?>
        </select>
        <input type="text" name="number">
        <input type="submit" value="Send" name="send">
        <input type="reset">
        </form>

        <?php 
        if(isset($_POST['send'])){
          $querystring='Call _newNumber (:_number, :_entID);';
          $stmt = $pdo->prepare($querystring);
          $stmt->bindParam(':_number', $_POST['number'], PDO::PARAM_INT);
          # select's name �r skiID
          $stmt->bindParam(':_entID', $_POST['entID'], PDO::PARAM_INT);
          # select's name �r type
          $stmt->execute();

  #uppdaterar sidan och visar nya l�nen
        //  header("Location: hemsida5.php");
        }
        ?>
      </div>


      <!-- ny ent anv�ndare -->
      <div>
        <h3>Create new Ent</h3>
        <form action='<?php $_PHP_SELF ?>' method='POST'>
          <input type="text" name="firstName" placeholder="firstname.."></p>
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


  try{ 
            $stmt->execute();                  
        }catch (PDOException $e){
            if($e->getCode()=="23000"){
                echo "Duplicate company code!";
            }else{
                echo "<p>".$e->getMessage()."</p>";
            }
        }

          }     
          ?>
        </div>


        <!-- ny ski anv�ndare -->
        <div>
          <h3>Create new Ski</h3>
          <form action='<?php $_PHP_SELF ?>' method='POST'>
            <input type="text" name="firstName" placeholder="firstname..">
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
