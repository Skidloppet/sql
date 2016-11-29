<?php
include 'connect.php';
SESSION_START();
?>
<!DOCTYPE html>
<html>
<head>
<title>Skidloppet AB - Monitor</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8">
<link rel="stylesheet" href="backend_style1.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
</head>

<body class="w3-light-grey">

      <!-- Top container & Sidenav/menu -->
      <?php
      include 'includes/sidemenu.php';
      ?>
		
	  <!-- Overlay effect when opening sidenav on small screens -->
      <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

      <!-- !PAGE CONTENT! -->
      <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <!-- Header -->
	  <header class="w3-container" style="padding-top:22px">
      <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
      </header>
	  
	 
	  
	 <div class="includes"></div>

        
		
		
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

//Meny AJAX
$('nav a').click(function() {
  $.ajax({
    type: 'GET',
    url: 'includes/'+$(this).data('content')+'.php',
    dataType: 'html',
    success: function(response) {
		//alert(response);
      $('.includes').html(response);
    }
  });
});
</script>

</body>
</html>
