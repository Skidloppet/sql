<?php
SESSION_START();
include'connect.php';
# funkar ej
# default_charset = "utf-8";


$sql = "CALL _removeComment()";
$stmt = $pdo->prepare($sql);
$stmt->execute();

?>



<!DOCTYPE html>
<html>
<title>Skidloppet AB</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link src="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
<style>
body {font-family: "Lato", sans-serif}
.mySlides {display: none}


/* Full-width input fields */
.login3{
	width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}


/* Set a style for all buttons */
button {
  background-color: #009933;
  color: white;
  padding: 3px 35px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 45%;
  border: 2px solid #ffffff; /* white */
}

/* Extra styles for the cancel button */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #009933;
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 40%;
  border-radius: ;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
  box-shadow: 10px 10px 5px #888888;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)}
  to {-webkit-transform: scale(1)}
}

@keyframes animatezoom {
  from {transform: scale(0)}
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
   display: block;
   float: none;
 }
 .cancelbtn {
   width: 100%;
 }
}


table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

<!-- div container för delsträckonra i en finare form samt tabell -->

div.container {
  width: 100%;
  border: 1px solid gray;
}

header, footer {
  padding: 6px;
  color: white;
  background-color: #009933;
  clear: left;
  text-align: center;
}

nav {
  float: left;
  max-width: 160px;
  margin: 0;
  padding: 1em;
}

nav ul {
  list-style-type: none;
  padding: 0;
}

nav ul a {
  text-decoration: none;
}

article {
  margin-left: 170px;
  border-left: 1px solid gray;
  padding: 1em;
  overflow: hidden;
}

<!-- skroll funktionen för kommentarer -->

#table-wrapper {
  position:relative;
}
#table-scroll {
  height:400px;
  overflow:auto;  
  margin-top:20px;
}

#table-wrapper table thead th .text {
  position:absolute;   
  top:-20px;
  z-index:2;
  height:20px;
  width:35%;
  border:1px solid red;
}

</style>

<body>
  <!-- Navbar -->
  <div class="w3-top">
    <ul class="w3-navbar w3-black	w3-card-2 w3-left-align">
      <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
        <a class="w3-padding-large" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
      </li>
      <li><a href="#" class="w3-hover-none w3-hover-text-grey w3-padding-large">Hem</a></li>
      <li class="w3-hide-small"><a href="#Status" class="w3-padding-large">Status</a></li>
      <li class="w3-hide-small"><a href="#Kommentar1" class="w3-padding-large">Kundernas kommentar</a></li> 
      <li class="w3-hide-small"><a href="#Snitt" class="w3-padding-large">Arenans status</a></li> 	  
      <li class="w3-hide-small"><a href="#Kommentar2" class="w3-padding-large">Kommentera sträckan</a></li>


      <!-- kollar om man INTE är inloggad -->
      <?php
      if (!isset($_SESSION['email'])) {
        ?>



        <li style="float: right" >
          <a href="kundE.php" <i class="fa fa-globe w3-xxlarge" aria-hidden="true"></i></a>
        </li>
        <!-- <i class="fa fa-globe w3-xxxlarge" aria-hidden="true"></i> -->



        <li style="float: right">
          <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Logga in</button>
        </li>

        <?php
      }
      elseif (isset($_SESSION['email'])){
        ?>

        <li style="float: right; margin:0px 10px 0px 10px; ">
          <form action="backend.php" >
            <button style="width:auto;"> backend </button>
          </form>
        </li>
        <li style="float: right">
          <form action="logout.php" >
            <button style="width:auto;">Logga ut: <?php echo $_SESSION[email];?></button>
          </form>
        </li>

        <?php
      }
      ?>

      <div id="id01" class="modal">

        <form class="modal-content animate" action="skidlogin.php" method="POST">
          <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="Logotype.jpg" alt="Avatar" class="avatar">
          </div>

          <div class="container">
           <div class="login3">

            <label><b><b>Email</b></b></label>
            <input type="text" placeholder="Exempel@hotmail.com" name="email" required>

            <label><b><b>Password</b></b></label>
            <input type="password" placeholder="******" name="pass" required>

            <font color="#009933"><button type="submit">Logga in</button></font>
            <input type="checkbox" checked="checked"> <font color="#009933">Kom ihåg mig </font>
          </div>
        </div>

        <div class="container" style="background-color:#grey">

          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>

        </div>
      </form>
    </div>
  </ul>

</div>

<!-- Page content -->
<div class="w3-content" style="max-width:2000px;margin-top:46px">

  <!-- Automatic Slideshow Images -->
  <div class="mySlides w3-display-container w3-center">
    <img src="Sny1.jpg" style="width:100%;height:450px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <p></p>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
    <img src="ny2.jpg" style="width:100%;;height:450px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3></h3>
      <p><b></b></p>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
    <img src="ny3.jpg" style="width:100%;height:450px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3></h3>
      <p><b></b></p>
    </div>
  </div>

  
  <!-- kartan -->  
  <div class="w3-container w3-content w3-padding-64" style="max-width:950px" id="Status">
    <?php
    include'includes/mapFkund.php';
    ?>

  </div>





  <div class="w3-container w3-content w3-padding-64" style="max-width:950px" id="Kommentar1">

    <!-- container för delsträckorna -->
    <div class="container">

      <header>
       <h1>Delsträckornas status </h1>
     </header>

     <nav>
      <ul>
       <li> <h2> Välj delsträcka </h2></li>
       <li><a href="?DS=1">Hedemora 1:1</a></h4></li>
       <li><a href="#">Hedemora 1:2</a></li>
       <li><a href="#">Hedemora 1:3</a></li>
     </ul>
   </nav>

   <article>
    <h1>Skidloppet</h1>
    <h3>Betygsförklaring</h3>

    <table>
      <tr>
        <th><i class="fa fa-map-marker" aria-hidden="true"></i>Sträckans namn</th>
        <th><i class="fa fa-calendar" aria-hidden="true"></i>Start datum</th>
        <th><i class="fa fa-trophy" aria-hidden="true"></i>Betyg</th>
        <th>Underlag</th>
        <th>Kanter</th>
        <th>Fäste</th>
        <th><i class="fa fa-snowflake-o" aria-hidden="true"></i>Djup(cm)</th>
        <th><i class="fa fa-road" aria-hidden="true"></i>Längd (km)</th>
        <th><i class="fa fa-arrows-v" aria-hidden="true"></i>m.ö.h</th>
      </tr>
    </div>
  </div>
</article>

<footer>Vald delsträcka</footer>

</div>


<?php

if(isset($_GET['DS'])){

  $query='SELECT * FROM KundDetaljer where rspName = :DS';
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':DS', $_GET['DS']);
  $stmt->execute();

  foreach($stmt as $key => $row){
   $stars = "";
   for($i=0;$i<$row["rating"];$i++){
     $stars .= "★";
   }
   echo '<tr>';
   echo "<td>".$row['realname']."</td>";
   echo "<td>".$row['startDate']."</td>";
   echo "<td>".$stars."</td>";
   echo "<td>".$row['underlay']."</td>";
   echo "<td>".$row['edges']."</td>";
   echo "<td>".$row['grip']."</td>";
   echo "<td>".$row['depth']."</td>";
   echo "<td>".$row['length']."</td>";
   echo "<td>".$row['height']."</td>";
   echo "</tr>"; 
 }
}
echo "</table>";
?>
</div>




<div class="container">

  <header>
   <h1>Kundkommentarer</h1>
 </header>
 <nav>
  <ul>
    <li style="float: right">
      <button onclick="document.getElementById('id02').style.display='block'" style="width:auto;"><i class="fa fa-flag w3-xxlarge" aria-hidden="true"></i></button>
    </li>
    <li>För felanmälan </li>




    <div id="id02" class="modal">

      <div class="container">
        <div id="11" class="w3-container w3-white">
          <head>
            <h3>Ny felanmälan!</h3>
          </header>

          <form action='<?php echo $_SERVER['SCRIPT_NAME']; ?>' method='POST'>
            <textarea rows="5" cols="70" name="desc" placeholder="Beskriv problemet..."></textarea>
          </br>

          <p>Ange problemets typ *</p>
          <select name="type">
            <?php
            $sql = 'SHOW COLUMNS FROM Error WHERE field="type"';
            $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
              print("<option>$option</option>");
            }
            ?>
          </select>

          <!-- Listbox till att välja startsträcka-->
          <p>Vart startade problemet?:</p>
          <select name='Start'>    
            <?php 
            foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
              echo '<option value="'.$row['name'].'">';
              echo $row['realName'];
              echo "</option>";
            }
            ?>
          </select><br>
          <!-- Listbox till att välja slutsträcka-->
          <p>Vart slutar problemets inverkan?:</p>
          <select name='Slut'>    
            <?php 
            foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
              echo '<option value="'.$row['name'].'">';
              echo $row['realName'];
              echo "</option>";
            }
            ?>
          </select><br><br>

          <!--<input type="text" name="Slut" placeholder="Slut.."></p>-->


          <p><button type="submit" name="Error">skicka in felanmälan</button></p></form>


          <?php
#  $em = $_SESSION['email'];

          if(isset($_POST['Error'])){

            $sql = "CALL _NewError(:newErrorDesc, :newEntID, NOW() , :newType, :startName, :endName);";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":newErrorDesc", $_POST['desc'], PDO::PARAM_STR);
            $stmt->bindParam(":newEntID", $_SESSION['id'], PDO::PARAM_INT);
    //$stmt->bindParam(":newGrade", $_POST['grade'], PDO::PARAM_STR);
            $stmt->bindParam(":newType", $_POST['type'], PDO::PARAM_STR);
            $stmt->bindParam(":startName", $_POST['Start'], PDO::PARAM_INT);
            $stmt->bindParam(":endName", $_POST['Slut'], PDO::PARAM_INT);
            $stmt->execute();
          }    
          ?>
        </div>


      </div>

    </form>
  </div>




</ul>
</nav>



<article>
  <h1>Skidloppet</h1>
  <h3>Kundernas kommentar </h3>
  <div id="table-wrapper">
    <div id="table-scroll"> 
      <table>
        <tr>
          <th><i class="fa fa-comments" aria-hidden="true"></i>kommentar</th>
          <th><i class="fa fa-user" aria-hidden="true"></i>Namn</th>
          <th><i class="fa fa-trophy" aria-hidden="true"></i>Betyg</th>
          <th><i class="fa fa-calendar-o" aria-hidden="true"></i>Datum</th>
          <th><i class="fa fa-id-badge" aria-hidden="true"></i>Sträckans namn</th>
        </tr>
      </div>

    </article>
    <footer> Kommentarer </footer>
  </div>


  <?php

  if(isset($_GET['DS'])){

    $query='SELECT * FROM KundComment where rspName = :DS LIMIT 30';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':DS', $_GET['DS']);
    $stmt->execute();

    foreach($stmt as $key => $row){
      echo '<tr>';
      echo "<td>".$row['kommentar']."</td>";
      echo "<td>".$row['alias']."</td>";
      echo "<td>".$row['grade']."</td>";
      echo "<td>".$row['date']."</td>";
      echo "<td>".$row['realname']."</td>";

      echo "</tr>"; 
    }
  }
  echo "</table>";
  ?>
</div>



<div class="w3-container w3-content w3-padding-64" style="max-width:950px" id="Snitt">

  <div class="container">
    <div class="w3-threethird">

      <header>
       <h1>Snittbetyg på hela arenan</h1>
     </header>
     <?php

     foreach($pdo->query( 'SELECT * FROM snittBetyg, snitt;' ) as $row){

      # kolla VIEW snittBetyg & snitt
      # lade till B tagg för att göra snittet enklare att se (row r,u,e,g /5)

      echo '<p>Helhetsbetyg</p>';
      echo '<div class="w3-progress-container w3-grey">';

      echo '<div id="myBar" class="w3-progressbar w3-green" style="width:'.$row["rat"].'%">';
      echo '<div class="w3-center w3-text-white"><b>'.$row["r"].'/5</b></div>';
      echo 'echo   </div>';
      echo ' </div>';
      echo '   <p>Underlag</p>';
      echo ' <div class="w3-progress-container w3-grey">';

      echo '  <div id="myBar" class="w3-progressbar w3-blue" style="width:'.$row["under"].'%">';
      echo '   <div class="w3-center w3-text-white"><b>'.$row["u"].'/5</b></div>';
      echo '   </div>';
      echo ' </div>';

      echo '  <p>Spårkanter</p>';
      echo ' <div class="w3-progress-container w3-grey">';
      echo '  <div id="myBar" class="w3-progressbar w3-green" style="width:'.$row["edge"].'%">';
      echo '    <div class="w3-center w3-text-white"><b>'.$row["e"].'/5</b></div>';
      echo '   </div>';
      echo ' </div>';

      echo ' <p>Stavfäste</p>';
      echo '<div class="w3-progress-container w3-grey">';
      echo ' <div id="myBar" class="w3-progressbar w3-blue" style="width:'.$row["grip"].'%">';
      echo '    <div class="w3-center w3-text-white"><b>'.$row["g"].'/5</b></div>';
      echo '  </div>';
      echo ' </div></br>';

    }
    ?>
  </div>
</div>
</br>

</div>



<div class="w3-container w3-content w3-padding-64" style="max-width:950px" id="Kommentar2">
  <div class="w3-container w3-content w3-padding-64" style="max-width:950px">
    <header>
     <h1>Kommentera sträcka</h1>
   </header>
   <h3>Ny kundkommentar</h3>
   <form action ='Kund.php' method='POST'>
    <textarea rows="5" cols="70" name="comment" placeholder="freetext !comment"></textarea>
  </br>
  <input type="text" name="alias" placeholder="Namn">
  <select name='grade'>
    <option selected="selected">Betygsätt spåren</option>
    <option value="1">1 - Ej åkbart</option>
    <option value="2">2 - Undermåliga spår</option>
    <option value="3">3 - Okej</option>
    <option value="4">4 - Bra spår</option>
    <option value="5">5 - Perfekt</option>
  </select>
  <select size='1' name='startName'>
    <option selected="selected"> Välj startpunkt </option>
    <?php    
    foreach($pdo->query( 'SELECT * FROM SubPlace where name<"21" ORDER BY name;' ) as $row){
      echo '<option value="'.$row['name'].'">';
      echo $row['realName'];      
      echo '</option>';
    }               

    ?>
  </select>

  <select size='1' name='endName'>
    <option selected="selected"> Välj slutpunkt </option>
    <?php    
    foreach($pdo->query( 'SELECT * FROM SubPlace where name<"21" ORDER BY name;' ) as $row){
      echo '<option value="'.$row['name'].'">';
      echo $row['realName'];      
      echo '</option>';
    }    
    ?>
  </select>

  <button type="submit" name="CreateComment">Skicka kommentar</button>

</form>


<?php
  # skapa ett errormedelande vid fel input (inget alias, kommentar över 1024 tecken, inget start/slut)

if(isset($_POST['CreateComment'])){
  /*deleteC skulle vart bättre att göra i mysql som ett event men då man måste ha super behörighet för detta gjordes det i php 
  med koden: DELETE FROM Commenta WHERE date < NOW() - INTERVAL 48 HOUR; i mysql. nackdelen med detta är att kommentarerna endast tas bort 
  när någon skriver en ny. Om man gjort ett mysql event kunde man ställt in så att detta tas bort i ett bestämmt intervall*/

    #$deleteC = "DELETE FROM Commenta WHERE date < NOW() - INTERVAL 48 HOUR;";
  $sql = "CALL _NewComment(:newComment, :newAlias, :newGrade, now(), :startName, :endName);";
  $stmt = $pdo->prepare($sql);
    #$stmt = $pdo->query($deleteC);

  $stmt->bindParam(":newComment", $_POST['comment'], PDO::PARAM_STR);
  $stmt->bindParam(":newAlias", $_POST['alias'], PDO::PARAM_STR);
  $stmt->bindParam(":newGrade", $_POST['grade'], PDO::PARAM_INT);
  $stmt->bindParam(":startName", $_POST['startName'], PDO::PARAM_INT);
  $stmt->bindParam(":endName", $_POST['endName'], PDO::PARAM_INT);
  $stmt->execute();
}  
?>
</div>
</div>



</div>


<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge" style="max-width:100%">
  <div value="center">
    Skidloppet<br>
    For english press the globe on top right corner</a>
  </div>
</footer>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


var modal = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}





// Automatic Slideshow - change image every 4 seconds
var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
   x[i].style.display = "none";
 }
 myIndex++;
 if (myIndex > x.length) {myIndex = 1}
  x[myIndex-1].style.display = "block";
setTimeout(carousel, 4000);
}

// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}

// When the user clicks anywhere outside of the modal, close it
var modal = document.getElementById('ticketModal');
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


<!-- FELANMÄLAN -->

// Get the modal
var modal = document.getElementById('id02');







<!-- script för felanmällan -->

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