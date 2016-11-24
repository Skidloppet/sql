<!DOCTYPE html>
<?php
session_start();
include 'connect.php';
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

.HoverButton:hover { background: Red; }
.HoverButton2:hover { background: Green; }
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
   include './backend_cannon_headerbox.php';
    ?>

    <div class="w3-container w3-section">
      <div class="w3-row-padding" style="margin:0 -16px">

        <div class="w3-threethird">
          <?php
          //include './backend_feeds.php';
          ?>
        </div>
        <hr>

<div>
	<h3>Lägg till snökanon</h3>
	<form action='<?php $_PHP_SELF ?>' method="post">
		<select size='1' name='status'>
			<option value="on"> On</option>
			<option value="off" selected="selected"> Off</option>
			<option value="broken" > Broken</option>
			<option value="unplugged"> Unplugged</option>
			</select><br></br>
		<input type="text" name="subPlaceName" placeholder="plats.."></p>
		<input type="text" name="model" placeholder="modell.."></p>
		<input type="text" name="effect" placeholder="effekt.."></p>
		<input type="submit" value="Lägg till"/>


	<?php
	    if(isset($_POST['subPlaceName'])){
	        $sql="CALL NewCannon(:subPlaceName,:model,:status,:effect)";
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':subPlaceName', $_POST['subPlaceName'],PDO::PARAM_INT);
	        $stmt->bindParam(':model', $_POST['model'],PDO::PARAM_STR);
	        $stmt->bindParam(':status', $_POST['status'],PDO::PARAM_STR);
			$stmt->bindParam(':effect', $_POST['effect'],PDO::PARAM_INT);
	        $stmt->execute();
	    }
	?>
</div>

<div class="w3-container">
  <h3>Utskrift av snökanoner</h3>
    <table border="1">
      <?php  
        echo "<tr>";
        echo "<th style='background-color:white;'>Plats:</th>"; 
        echo "<th style='background-color:white;'>modell:</th>";
        echo "<th style='background-color:white;'>status:</th>";
        echo "<th style='background-color:white;'>effekt:</th>";
        echo "</tr>";


    foreach($pdo->query( 'SELECT * FROM Cannon;' ) as $row){
      echo "<tr>";
      echo "<td>".$row['subPlaceName']."</td>";
      echo "<td>".$row['model']."</td>";
      echo "<td>".$row['status']."</td>";
      echo "<td>".$row['effect']."</td>";
      echo "</tr>"; 
    }
?>
</table>
</div>

<footer class="w3-container w3-padding-16 w3-light-grey">
  <!-- <h4>FOOTER</h4> -->
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
