<!DOCTYPE html>
<?php
include'../connect.php';
SESSION_START();
$id = $_SESSION['id'];

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

  include 'errorreport/err_headerbox_arenachef.php';
  ?>
  <div class="w3-container w3-section">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-threethird">
        <?php
        include 'errorreport/err_feeds_arenachef.php';
      }
      elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'other')) {

        include 'errorreport/err_headerbox_other.php';
        ?>
        <div class="w3-container w3-section">
          <div class="w3-row-padding" style="margin:0 -16px">
            <div class="w3-threethird">
              <?php
              include 'errorreport/err_feeds_other.php';
            }
            elseif (isset($_SESSION['email'])&&($_SESSION['type'] > '1')) {

              include 'errorreport/err_headerbox_ent.php';
              ?>
              <div class="w3-container w3-section">
                <div class="w3-row-padding" style="margin:0 -16px">
                  <div class="w3-threethird">
                    <?php
                    include 'errorreport/err_feeds_ent.php';
                  }
                  else{
                    echo "if this message is showing your logged in as a hacker or smt";
                  }

                  ?>
                </div>
                <hr>
                <!-- End page content -->
              </div>
            </div>
          </div>
          </div></div></div></div></div>

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
