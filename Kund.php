<?php
SESSION_START();
include'connect.php';
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
  <button style="width:auto;">Logga ut</button>
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

      <label><b>Username</b></label>
      <input type="text" placeholder="Emailadress" name="email" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Lösenord" name="pass" required>
        
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
<!--
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
-->
<!-- div för kartan -->


<!-- Add Google Maps -->
<div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="Status">
<svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 634.39 189.23">
<defs>
<style>
.cls-1,.cls-4,.cls-5,.cls-7{fill:none;}
.cls-1,.cls-2,.cls-6,.cls-7{stroke:#231f20;}
.cls-2,.cls-3{fill:#231f20;}
.cls-4{stroke:#0365f4;}
.cls-4,.cls-5,.cls-6,.cls-7{stroke-miterlimit:10;}
.cls-4,.cls-5,.cls-7{stroke-width:2px;}
.cls-5{stroke:#d2d1e6;}
.cls-6{fill:#e71e25;}
</style>
<symbol id="Compass_Rose" data-name="Compass Rose" viewBox="0 0 51.15 60.64">
<path class="cls-1" d="M30.77,26.28a10.22,10.22,0,1,1-5.19-1.42A10.2,10.2,0,0,1,30.77,26.28Z"/><path class="cls-1" d="M20.38,26.28a10.21,10.21,0,0,1,10.38,0L25.47,11Z"/>
<path class="cls-2" d="M25.58,24.86a10.16,10.16,0,0,1,5.19,1.42L25.47,11V24.86h0.11Z"/>
<path class="cls-1" d="M16.79,40.25a10.22,10.22,0,0,1,0-10.38L1.55,35.17Z"/>
<path class="cls-2" d="M15.37,35.06a10.16,10.16,0,0,1,1.42-5.19L1.55,35.17H15.38V35.06Z"/>
<path class="cls-1" d="M30.77,43.85a10.13,10.13,0,0,1-5.19,1.42,10.14,10.14,0,0,1-5.19-1.42l5.3,15.24Z"/>
<path class="cls-2" d="M25.58,45.27a10.14,10.14,0,0,1-5.19-1.42l5.3,15.24V45.26H25.58Z"/>
<path class="cls-1" d="M34.36,29.87a10.21,10.21,0,0,1,0,10.39L49.6,35Z"/>
<path class="cls-2" d="M35.78,35.06a10.15,10.15,0,0,1-1.42,5.19L49.6,35H35.78v0.11Z"/>
<path class="cls-3" d="M29.31,0.22c-0.67.08-1,.13-1,1.52V8H28.11L23.42,1.48h0V6.1c0,1.22.22,1.48,1,1.51V7.83H21.9V7.61c0.81-.06,1-0.24,1-1.51V0.87a1.07,1.07,0,0,0-1-.65V0h1.82L27.8,5.69h0v-4c0-1.36-.3-1.46-1-1.52V0h2.5V0.22Z"/>
</symbol>
</defs>
<title>karta_kund_3</title>
<path class="cls-4" d="M375.87,277.12c8.9-4.43,12.25-9.46,13.58-13.43,2.18-6.48-.7-11,2.52-15.91,2.62-4,7.16-5,13.43-6.47,20.91-4.92,32.59-7.71,32.6-9.69,0-2.81-23.55.68-33.13-12.29-7.17-9.7-3-23.77-2-27.12,4.46-14.91,16.48-22.67,23.6-27.26" transform="translate(-77.06 -164.09)"/>
<path class="cls-4" d="M545.3,307.11c3.5-20.69,7.87-34.72,11.38-43.95,2.94-7.74,5.75-13.35,6.24-22.47,0.36-6.69-.77-10.54,1.35-17.66,1.92-6.43,3.88-6.75,4.41-11.59,0.76-7-3-8.73-4-16.89-0.92-7.94,2.4-8.54,2.63-18" transform="translate(-77.06 -164.09)"/>
<path class="cls-4" d="M140.72,244.53a296.69,296.69,0,0,1,42.79-2.82c29.18,0.2,50.15,4.67,70.25,9,15,3.2,22.12,5.54,29.5,9.15C293,264.59,305.76,271,312.34,285a43.93,43.93,0,0,1,4,19.63" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M704,278.67a14.2,14.2,0,0,1,3.23,3.77c4.63,8.08,0,22.08-12.29,33.13" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M668.83,235.68c4.29,8,5.87,15.58,3.13,19.17-1.7,2.22-4.92,2.74-6.47,6.63-1.32,3.31-1.07,8.16,1.55,10.64,3.53,3.32,8.7-.13,17.31.06,6.22,0.14,14.53,2.19,19.66,6.5" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M636.54,206.77a67.45,67.45,0,0,1,18.35,11.29,65.14,65.14,0,0,1,13.95,17.62" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M601.52,202.1c10-2.18,23-.36,35,4.68" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M577.42,238.07c10.15-9.74,4-21,11.89-29.57,2.95-3.21,7.19-5.31,12.21-6.4" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M526.92,249.1a201,201,0,0,0,25.79-2.83c17.7-3,21.71-5.33,24.71-8.21" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M487.46,260.87a67.76,67.76,0,0,1,14.46-8.18c9.24-3.76,14.25-3.13,25-3.59" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M445,295.88q0.84-.11,1.68-0.27c9.86-2,11.78-9.23,26.3-22.48a171.12,171.12,0,0,1,14.48-12.26" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M419.72,243.5c-1.12,6.16-2.67,12.85-4.71,20-0.21,7.73-.22,15.08,4.57,21.56,5.48,7.41,16,12,25.43,10.77" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M420.67,206.31c1.95,8.32,2,20.9-1,37.19" transform="translate(-77.06 -164.09)"/><path class="cls-5" d="M383.53,211.22c4.9-4.29,5.57-9.36,13.38-13.23,2-1,12.36-6.13,18.06-2.22,2.47,1.69,4.47,5.25,5.7,10.53" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M346.49,230.71c3.24-7,5.72-11,8.85-12.94,8.72-5.35,14.18,1.6,24.49-4a20.12,20.12,0,0,0,3.71-2.56" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M329.93,263.52c4.67-2,5.15-6.4,11.45-21.14,2-4.58,3.61-8.44,5.11-11.67" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M295.8,265.61c6.94-4.56,7.81-5.56,15.29-5.19,10.28,0.5,13.15,5.52,18.84,3.1" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M252.07,293.69c9.16,3,20,.47,25.08-5.92,3.8-4.8,1.83-12.17,4.52-13.7,6.69-3.67,11-6.42,14.14-8.47" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M235.4,213.85c3.27-2.43,6.38-3.92,9.47-2.92,5.31,1.73,8.52,10.19,7.18,16-1.43,6.24-7.23,5.59-10.37,12.55-3.65,8.08,2.67,12.28-.39,23.62-1.92,7.09-4.91,7.37-4.87,12.41,0.06,7.44,6.66,14.16,13,17.15a23.32,23.32,0,0,0,2.62,1" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M206.21,225.83a14.7,14.7,0,0,0,4.45,1.46c9.85,1.52,17.67-8.18,24.74-13.45" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M158.89,230a26.91,26.91,0,0,1,8.86-17.87c6.8-5.9,18-8.88,24.31-4.64,5.56,3.75,8.76,14.18,8.76,14.18a20.45,20.45,0,0,0,5.39,4.13" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M157.13,261.53a9.93,9.93,0,0,1,2.23-2.09c6.42-4.36,16.53.26,17.42-2,1-2.5-11.74-5.94-16.25-16.26A23,23,0,0,1,158.89,230" transform="translate(-77.06 -164.09)"/>
<path class="cls-5" d="M153.93,282.37c-0.79-7.89-.5-16.14,3.2-20.84" transform="translate(-77.06 -164.09)"/>
<circle class="cls-6" cx="206.21" cy="227.48" r="5.67" transform="translate(-130.16 -101) rotate(-15.44)"/>
<circle class="cls-6" cx="601.52" cy="203.13" r="5.67" transform="matrix(0.96, -0.27, 0.27, 0.96, -109.42, 3.33)"/>
<circle class="cls-6" cx="486.92" cy="260.87" r="5.67" transform="translate(-128.92 -25.09) rotate(-15.44)"/>
<circle class="cls-6" cx="383.15" cy="210.79" r="5.67" transform="translate(-119.34 -54.51) rotate(-15.44)"/>
<circle class="cls-6" cx="154.82" cy="285.59" r="5.67" transform="matrix(0.96, -0.27, 0.27, 0.96, -147.48, -112.58)"/>
<circle class="cls-6" cx="295.8" cy="267.18" r="5.67" transform="translate(-137.49 -75.72) rotate(-15.44)"/>
<circle class="cls-6" cx="693.67" cy="315.94" r="5.67" transform="translate(-136.12 31.92) rotate(-15.44)"/>
<line class="cls-7" x1="75.98" y1="90" x2="85.97" y2="104.89"/>
<line class="cls-7" x1="73.36" y1="65.48" x2="91.26" y2="66.42"/>
<line class="cls-7" x1="153.76" y1="42.94" x2="163.75" y2="57.82"/>
<line class="cls-7" x1="174.12" y1="139.85" x2="175.9" y2="119.99"/>
<line class="cls-7" x1="248.52" y1="90.6" x2="256.68" y2="106.56"/>
<line class="cls-7" x1="261.58" y1="62.29" x2="278.94" y2="70.95"/>
<line class="cls-7" x1="335.8" y1="44.38" x2="352.2" y2="39.85"/>
<line class="cls-7" x1="334.58" y1="78.95" x2="352.48" y2="79.89"/>
<line class="cls-7" x1="367.93" y1="140.6" x2="367.93" y2="122.68"/>
<line class="cls-7" x1="449.37" y1="76.01" x2="450.36" y2="93.91"/>
<line class="cls-7" x1="494.62" y1="67.61" x2="504.61" y2="82.49"/>
<line class="cls-7" x1="555.57" y1="51.69" x2="563.38" y2="35.55"/>
<line class="cls-7" x1="583.58" y1="74.17" x2="599.97" y2="69.65"/>
<line class="cls-7" x1="618.95" y1="120.26" x2="633.83" y2="110.26"/>
<use width="51.15" height="60.64" transform="translate(-9.36 137.62) rotate(-15.44)" xlink:href="#Compass_Rose"/>
</svg>
<br>

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
  
  <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="Kontakt">
    <h3>skriver bara ut den som en enkel tabell för test</h3>
    <h4>  <a href="karta.php">tillfällig länk till karta.php</a>
</h4>
    <table>
<tr>
    <th>name</th>
    <th>startDate</th>
    <th>rating</th>
    <th>underlay</th>
    <th>edges</th>
    <th>grip</th>
    <th>depth</th>
    <th>length</th>
    <th>height</th>
    <th>realname</th>
</tr>
    <?php

        if(isset($_GET['DS'])){
          
            $query='SELECT * FROM KundDetaljer where rspName = :DS';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':DS', $_GET['DS']);
            $stmt->execute();

      foreach($stmt as $key => $row){
          echo '<tr>';
          echo "<td>".$row['rspName']."</td>";
          echo "<td>".$row['startDate']."</td>";
          echo "<td>".$row['rating']."</td>";
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








  <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="Kontakt">
    <h3>kundkommentarer (limit 5)</h3>
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





  
  
<div>
	<h3>Lägg till en kundkommentar</h3>
	<form action='' method='POST'>
		<textarea rows="5" cols="70" name="comment" placeholder="freetext comment"></textarea>
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
			    <option value="1">Hedemora 3:1</option><option value="2">Hedemora 3:2</option><option value="3">Hedemora 3:3</option><option value="4">Hedemora2 3:1</option><option value="5">Hedemora2 3:2</option><option value="6">Hedemora2 3:3</option>	    </select>

	    <select size='1' name='endName'>
	    	<option selected="selected"> Välj slutpunkt </option>
			    <option value="1">Hedemora 3:1</option><option value="2">Hedemora 3:2</option><option value="3">Hedemora 3:3</option><option value="4">Hedemora2 3:1</option><option value="5">Hedemora2 3:2</option><option value="6">Hedemora2 3:3</option>	    </select>

		<button type="submit" name="CreateComment">Skicka in kommentar</button>
	</form>


</div>






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

