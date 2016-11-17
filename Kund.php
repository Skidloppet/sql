<!DOCTYPE html>
<html>
<title>W3.CSS Template</title>
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
    width: 100%;
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
  <li class="w3-hide-small"><a href="#Kontakt" class="w3-padding-large">Kontakta oss</a></li>
  
<li style="float: right">
<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Logga in</button>
</li>
<div id="id01" class="modal">
  
  <form class="modal-content animate" action="action_page.php">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="Logotype.jpg" alt="Avatar" class="avatar">
    </div>

    <div class="container">
	<div class="login3">
      <label><b>Username</b></label>
      <input type="text" placeholder="Användarnamn" name="uname" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Lösenord" name="psw" required>
        
      <button type="submit">Logga in</button>
      <input type="checkbox" checked="checked"> <font color="black">Kom ihåg mig </font>
	  </div>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw">Glömt <a href="#">password?</a></span>
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
    <img src="ny1.jpg" style="width:100%">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <p><b></b></p>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
    <img src="ny2.jpg" style="width:100%">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3></h3>
      <p><b></b></p>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
    <img src="ny3.jpg" style="width:100%">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3></h3>
      <p><b></b></p>
    </div>
  </div>

<!-- div för kartan -->



<!-- Add Google Maps -->
<div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="Status">
<?php include 'karta_kund_3.php' ?>

<br>

<select id="Sträcka" name="Sträcka">                  
<option value="0">Välj status för valfri sträcka</option>
<option value="1">sträcka 1</option>
<option value="2">sträcka 2</option>
<option value="3">sträcka 3</option>
<option value="4">sträcka 4</option>
<option value="5">sträcka 5</option>
<option value="6">sträcka 6</option>
<option value="7">sträcka 7</option>
<option value="8">sträcka 8</option>
<option value="9">sträcka 9</option>
<option value="10">sträcka 10</option>
<option value="10">sträcka 11</option>
<option value="10">sträcka 12</option>
<option value="10">sträcka 13</option>
<option value="10">sträcka 14</option>
<option value="10">sträcka 15</option>
<option value="10">sträcka 16</option>
<option value="10">sträcka 17</option>
<option value="10">sträcka 18</option>
<option value="10">sträcka 19</option>
<option value="10">sträcka 20</option>
</select>




<?php
	$pdo = new PDO('mysql:dbname=SlitABSkidloppet;host=localhost','sqllab','Tomten2009');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

	              
	echo "<table border='1'>";
	echo "<th>Rating</th><th>Underlay</th><th>Edges</th><th>Grip</th><th>Depth ( Cm )</th>";	
	foreach ($pdo->query("select * from Report") as $row) {
            echo "<tr>";
            echo "<td>".$row['rating']."</td>";
            echo "<td>".$row['underlay']."</td>";
            echo "<td>".$row['edges']."</td>";
		    echo "<td>".$row['grip']."</td>";
			echo "<td>".$row['depth']."</td>";
            echo "</tr>";
            }
	echo "</table>";
?>

  <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="Kommentar1">
  <form action="Kund.php" method="POST">
	<table>
    <h2 class="w3-wide w3-center">Kundernas kommentarer</h2>
	 <p class="w3-opacity w3-center"><i>Kommentera sträckorna du åkt på</i></p>
	</table>
  </form>
  </div>
  <?php
	$pdo = new PDO('mysql:dbname=SlitABSkidloppet;host=localhost','sqllab','Tomten2009');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

	              
	echo "<table border='1'>";
	echo "<th>Kommentar</th><th>Alias</th><th>Betyg</th><th>Datum</th>";	
	foreach ($pdo->query("select * from Commenta") as $row) {
            echo "<tr>";
            echo "<td>".$row['kommentar']."</td>";
			echo "<td>".$row['alias']."</td>";
			echo "<td>".$row['grade']."</td>";
			echo "<td>".$row['date']."</td>";
            echo "</tr>";
            }
	echo "</table>";
?>
  
  
  
  
  
  
  <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="Kommentar2">
  <form action="Kund.php" method="POST">
	<table>

    <h2 class="w3-wide w3-center">Kundernas kommentar</h2>
	<p class="w3-opacity w3-center"><i>Kommentera sträckorna du åkt på</i></p>
	<form action="Kund.php" method="post">
	<td>  Namn:<input type="text" name="alias"> <br></td>
	<td>  Betyg 1-5:<input type="text" name="grade"><br></td>
	<tr><td colspan="2">Comment: </td></tr>
	<tr><td colspan="5"><textarea name="kommentar" rows="10" cols="39"></textarea></td></tr>
	<tr><td colspan="2"><input type="submit" name="submit" value="Comment"></td></tr>

	</form>
	</table>
  </form>
  </div>
<?php
		    if(isset($_POST['alias'])){
        $alias=$_POST['alias'];
		$grade=$_POST['grade'];
        $kommentar=$_POST['kommentar'];
        $sql = 'INSERT INTO Commenta(alias,grade,kommentar) VALUES(:alias,:grade,:kommentar);';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':alias', $alias);
		$stmt->bindParam(':grade', $grade);
		$stmt->bindParam(':kommentar', $kommentar);

         try{ 
            $stmt->execute();                  
        }catch (PDOException $e){
            if($e->getCode()=="23000"){
                echo "Duplicate company code!";
            }else{
                echo $e->getMessage();
            }
        }
        
    }
?>





  <!-- The Contact Section -->
  <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="Kontakt">
    <h2 class="w3-wide w3-center">Kontakt oss</h2>
    <p class="w3-opacity w3-center"><i>Skidloppet AB</i></p>
    <div class="w3-row w3-padding-32">
      <div class="w3-col m6 w3-large w3-margin-bottom">
        <i class="fa fa-map-marker" style="width:30px"></i> Ute på landet, Sv<br>
        <i class="fa fa-phone" style="width:30px"></i> Phone:(+46)31 71 71 71<br>
        <i class="fa fa-envelope" style="width:30px"> </i> E-mail: Exempel@mail.com<br>
      </div>
      <div class="w3-col m6">
        <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
          <div class="w3-half">
            <input class="w3-input w3-border" type="text" placeholder="Namn">
          </div>
          <div class="w3-half">
            <input class="w3-input w3-border" type="text" placeholder="E-mail">
          </div>
        </div>
        <input class="w3-input w3-border" type="text" placeholder="Kommentar">
        <button class="w3-btn w3-section w3-right">Skicka</button>
      </div>
    </div>
  </div>
  
<!-- End Page Content -->




<!--
if($_POST['submit'])
{
$animal=$_POST['animal'];
}
-->

</div>

</div>

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">

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

