<!DOCTYPE html>
<?php
include'../connect.php';
SESSION_START();
$id = $_SESSION['id'];
$em = $_SESSION['email'];
?>
    <?php
    if (!isset($_SESSION['email'])) {
      ?>
      <a href="Kund.php">
        <h3>logga in</h3>
      </a>
      <?php 
    } 
    elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {

      include 'comment/cuc_headerbox_arenachef.php';
      ?>      
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'comment/cuc_feeds_arenachef.php';
          }
          elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'other')) {
			  
      ?>
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'comment/cuc_feeds_other.php';
          }
          elseif (isset($_SESSION['email'])&&($_SESSION['type'] > '1')) {
			  
		    include 'comment/cuc_headerbox_ent.php';
      ?>
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'comment/cuc_feeds_ent.php';
          }
          else{
            echo "if this message is showing your logged in as a hacker or smt";
          }

        ?>
      </div>
      <hr>