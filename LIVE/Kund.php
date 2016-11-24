<?php
SESSION_START();
include'connect.php';
# funkar ej
# default_charset = "utf-8";
?>



<!DOCTYPE html>
<html>
<title>Skidloppet AB</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">



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
  background-color: #000000;
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
  background-color: #000000;
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
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
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


</style>

<body>

  <!-- Navbar -->
  <div class="w3-top">
    <ul class="w3-navbar w3-black w3-card-2 w3-left-align">
      <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
        <a class="w3-padding-large" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
      </li>
      <li><a href="#" class="w3-hover-none w3-hover-text-grey w3-padding-large">Hem</a></li>
      <li class="w3-hide-small"><a href="#Status" class="w3-padding-large">Status</a></li>
      <li class="w3-hide-small"><a href="#Kommentar1" class="w3-padding-large">Kundernas kommentar</a></li>  
      <li class="w3-hide-small"><a href="#Kommentar2" class="w3-padding-large">Kommentera sträckan</a></li>


      <!-- kollar om man INTE är inloggad -->
      <?php
      if (!isset($_SESSION['email'])) {
        ?>



        <li style="float: right">
          <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Logga in</button>
        </li>

        <?php
      }
      elseif (isset($_SESSION['email'])){
        ?>
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
            <img src="bilder/Logotype.jpg" alt="Avatar" class="avatar">
          </div>

          <div class="container">
           <div class="login3">

            <label><b>Email</b></label>
            <input type="text" placeholder="Emailadress" name="email" required>

            <label><b>Password</b></label>
            <input type="password" placeholder="Lösenord" name="pass" required>

            <font color="black"><button type="submit">Logga in</button></font>
            <input type="checkbox" checked="checked"> <font color="black">Kom ihåg mig </font>
          </div>
        </div>

        <div class="container" style="background-color:#f1f1f1">

          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>

		</div>
      </form>
    </div>
  </ul>




</div>
<!-- Navbar on small screens -->
<div id="navDemo" class="w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
  <ul class="w3-navbar w3-left-align w3-black">
    <li><a class="w3-padding-large" href="#Maps">Google Maps</a></li>
    <li><a class="w3-padding-large" href="#">Status</a></li>
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

<!-- div för kartan -->

<!-- Detaljer för del-sträckan 
<h1>Detaljer för del-sträckan</h1>
<table border='1'><th>Rating</th><th>Underlay</th><th>Edges</th><th>Grip</th><th>Depth ( Cm )</th><tr><td>1</td><td>2</td><td>3</td><td>4</td><td>54.0</td></tr><tr><td>3</td><td>3</td><td>2</td><td>4</td><td>65.0</td></tr><tr><td>2</td><td>2</td><td>4</td><td>3</td><td>43.0</td></tr></table>
  <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="Kommentar1">
  <form action="Kund.php" method="POST">
	<table>
    <h2 class="w3-wide w3-center">Kundernas kommentarer</h2>
	 <p class="w3-opacity w3-center"><i>Kommentera sträckorna du åkt på</i></p>
	</table>
  </form>
  </div>
  <table border='1'><th>Kommentar</th><th>Alias</th><th>Betyg</th><th>Datum</th></table>  
-->

<div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="Kommentar1">
  <h3>skriver bara ut den som en enkel tabell för test</h3>
  <h4>  <a href="?DS=1">sträcka ett (ingen karta)</a>
  </h4>
  <table>
    <tr>
      <th>Namn</th>
      <th>Start datum</th>
      <th>Betyg</th>
      <th>Underlag</th>
      <th>Kanter</th>
      <th>Fäste</th>
      <th>Djup (cm)</th>
      <th>Längd (km)</th>
      <th>m.ö.h</th>
      <th>Sträckans namn</th>
    </tr>
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
        echo "<td>".$row['rspName']."</td>";
        echo "<td>".$row['startDate']."</td>";
		echo "<td>".$stars."</td>";
        echo "<td>".$row['underlay']."</td>";
        echo "<td>".$row['edges']."</td>";
        echo "<td>".$row['grip']."</td>";
        echo "<td>".$row['depth']."</td>";
        echo "<td>".$row['length']."</td>";
        echo "<td>".$row['height']."</td>";
        echo "<td>".$row['realname']."</td>";
        echo "</tr>"; 
      }
    }
    echo "</table>";
    ?>
  </div>


  <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="Kommentar2">
    <h3>kundkommentarer</h3>
  </h4>
  <table>
    <tr>
      <th>rspName</th>
      <th>cmtID</th>
      <th>kommentar</th>
      <th>alias</th>
      <th>grade</th>
      <th>date</th>
      <th>realname</th>

    </tr>
    <?php

    if(isset($_GET['DS'])){

      $query='SELECT * FROM KundComment where rspName = :DS';
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(':DS', $_GET['DS']);
      $stmt->execute();

      foreach($stmt as $key => $row){
        echo '<tr>';
        echo "<td>".$row['rspName']."</td>";
        echo "<td>".$row['cmtID']."</td>";
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


  <div class="w3-container w3-content w3-padding-64" style="max-width:800px">
    <h3>Ny kundkommentar</h3>
    <form action ='Kund.php' method='POST'>
      <textarea rows="5" cols="70" name="comment" placeholder="freetext !comment"></textarea>
    </br>
    <input type="text" name="alias" placeholder="Alias..">
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


<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
<div value="center">
Skidloppet
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
</script>

</body>
</html>

