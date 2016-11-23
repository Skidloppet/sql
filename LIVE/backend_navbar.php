  <div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
    <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Meny</button>
    <span class="w3-right">Skidloppet AB</span>
    <?php
    if (isset($_SESSION['email'])){
      ?>
      <span class="w3-right">
        <form action="logout.php">
          <button class="w3-btn w3-margin-20 w3-hover-text-grey">
            Logga ut: <?php echo $_SESSION['email']; 
          }
          ?>
        </button>
      </div>