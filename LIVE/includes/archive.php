
  <!-- Header -->
  <?php
	include 'backend_headerbox.php';
	?>

  <div class="w3-container w3-section">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-threethird">
        <h5>Karta</h5>
	<?php
		include 'backend_map.php';
		?>
        <!-- <img src="images/karta_kund.svg" style="width:900px" "height:20%" alt="karta"> -->
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
  <hr>
  
