

    <?php
    if (!isset($_SESSION['email'])) {
      ?>
      <a href="Kund.php">
        <h3>logga in</h3>
      </a>
      <?php 
    } 
    elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {

      include 'subplace/backend_sp_headerbox_arenachef.php';
      ?>
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'report/backend_sp_feeds_arenachef.php';
          }
          elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'other')) {

      include 'report/backend_sp_headerbox_other.php';
      ?>
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'report/backend_sp_feeds_other.php';
          }
          elseif (isset($_SESSION['email'])&&($_SESSION['type'] > '1')) {

      include 'report/backend_sp_headerbox_ent.php';
      ?>
      <div class="w3-container w3-section">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'report/backend_sp_feeds_ent.php';
          }
          else{
            echo "if this message is showing your logged in as a hacker or smt";
          }

        ?>
  

      