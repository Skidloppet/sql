<?php
include'../connect.php';
SESSION_START();
$id = $_SESSION['id'];
$em = $_SESSION['email'];
#em används i ind_feeds_ent
?>


<div class="w3-container w3-section">
  <div class="w3-row-padding" style="margin:0 -16px">

    <!-- inlogg om ej inloggad -->

    <?php
    if (!isset($_SESSION['email'])) {
      ?>
      <div class="w3-container w3-section">
        <a href="Kund.php">
          <h3>logga in</h3>
        </a>
      </div>
      <?php 
    } 
#    <!-- include content beroende på inlogg -->

    elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {
		include 'index/ind_headerbox_arenachef.php';
      ?>
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'index/ind_feeds_arenachef.php';
          }
          elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'other')) {
			  include 'index/ind_headerbox_other.php';
            ?>
            <div class="w3-container w3-section">
              <div class="w3-row-padding" style="margin:0 -16px">
                <div class="w3-threethird">
                  <?php
                  include 'index/ind_feeds_other.php';
                }
                elseif (isset($_SESSION['email'])&&($_SESSION['type'] > '1')) {
					include 'index/ind_headerbox_ent.php';
                  ?>
                  <div class="w3-container w3-section">
                    <div class="w3-row-padding" style="margin:0 -16px">
                      <div class="w3-threethird">
                        <?php
                        include 'index/ind_feeds_ent.php';
                      }
                      else{
                        echo "if this message is showing your logged in as a hacker or smt";
                      }

                      ?>


                      <hr>
                    </div>

