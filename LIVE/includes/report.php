<!DOCTYPE html>
<?php
include'../connect.php';
SESSION_START();
date_default_timezone_set('Europe/Stockholm');
$id = $_SESSION['id'];
?>


<div id="report101" class="w3-container w3-section">

  <div class="w3-row-padding" style="margin:0 -16px">


  <?php
  if (!isset($_SESSION['email'])) {
    ?>
    <a href="Kund.php">
      <h3>logga in</h3>
    </a>
    <?php 
  } 
  elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {

    include 'report/rep_headerbox_arenachef.php';
    ?>
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-threethird">
        <?php
        include 'report/rep_feeds_arenachef.php';
      }
      elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'other')) {

        include 'report/rep_headerbox_other.php';
        ?>
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-threethird">
            <?php
            include 'report/rep_feeds_other.php';
          }
          elseif (isset($_SESSION['email'])&&($_SESSION['type'] > '1')) {

            include 'report/rep_headerbox_ent.php';
            ?>
            <div class="w3-row-padding" style="margin:0 -16px">
              <div class="w3-threethird">
                <?php
                include 'report/rep_feeds_ent.php';
              }
              else{
                echo "if this message is showing your logged in as a hacker or smt";
              }

              ?>
              <hr>
              </div>
            
            <?php
/*
 SESSION_START();
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
   include './backend_ErrorReport_headerbox.php';
    ?>

    <div class="w3-container w3-section">
      <div class="w3-row-padding" style="margin:0 -16px">

        <div class="w3-threethird">
          <?php
          //include './backend_feeds.php';
          ?>
        </div>
        <hr>

<!--
Ny felanmälan.
Kan vara värt att visa namn istället för ID på entreprenör?
Ändra name till realname (sträcka)
Fortsätta använda border på tabell? annars ser det ut som om all text står i en mening.
Göra om så att start / slut är listbox med realname?
-->

<?php
include'connect.php';
#include './backend_connect.php';
?>


<div class="w3-container">
  <h3>Ny Rapport</h3>
  <form action='<?php $_PHP_SELF ?>' method='POST'>
    <input type="text" name="WorkDate" placeholder="yyyy-mm-dd"></p>
    <input type="text" name="Depth" placeholder="Djup.."></p>

    <p>Helhetsbetyg:</p>
    <select name="Rating">
      <?php
      $sql = 'SHOW COLUMNS FROM Report WHERE field="rating"';
      $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
            print("<option>$option</option>");
       }
      ?>
    </select>

    <p>Underlag:</p>
    <select name="Underlay">
      <?php
      $sql = 'SHOW COLUMNS FROM Report WHERE field="underlay"';
      $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
            print("<option>$option</option>");
       }
      ?>
    </select>
  
    <p>Spårkanter:</p>
    <select name="Edges">
      <?php
      $sql = 'SHOW COLUMNS FROM Report WHERE field="edges"';
      $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
            print("<option>$option</option>");
       }
      ?>
    </select>

    <p>Stavfäste:</p>
    <select name="Grip">
      <?php
      $sql = 'SHOW COLUMNS FROM Report WHERE field="grip"';
      $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
            print("<option>$option</option>");
       }
      ?>
    </select>

    <p>Start</p>
    <select name='Start'>    
      <?php 
      foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
        echo '<option value="'.$row['name'].'">';
        echo $row['realName'];
        echo "</option>";
      }
      ?></select>
      <p>Slut</p>
    <select name='Slut'>    
      <?php 
      foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
        echo '<option value="'.$row['name'].'">';
        echo $row['realName'];
        echo "</option>";
      }
      ?></select><br><br>

    <textarea rows="5" cols="70" name="comment" placeholder="Kommentar..."></textarea>


    <p><button type="submit" name="_newReport">Ny rapport</button></p></form>

  <?php

  if(isset($_POST['_newReport'])){

    $sql = "CALL _newReport(:newEntID, now(), :newWorkDate, :newRating, :newUnderlay, :newEdges, :newGrip, :newDepth, :newComment, :startName, :endName)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":newEntID", $_SESSION['id'], PDO::PARAM_INT);
    //$stmt->bindParam(":newStartDate", $_POST['StartDate'], PDO::PARAM_STR);
    $stmt->bindParam(":newWorkDate", $_POST['WorkDate'], PDO::PARAM_STR);
    $stmt->bindParam(":newRating", $_POST['Rating'], PDO::PARAM_INT);
    $stmt->bindParam(":newUnderlay", $_POST['Underlay'], PDO::PARAM_INT);
    $stmt->bindParam(":newEdges", $_POST['Edges'], PDO::PARAM_INT);
    $stmt->bindParam(":newGrip", $_POST['Grip'], PDO::PARAM_INT);
    $stmt->bindParam(":newDepth", $_POST['Depth'], PDO::PARAM_INT);
    $stmt->bindParam(":newComment", $_POST['comment'], PDO::PARAM_STR);
    $stmt->bindParam(":startName", $_POST['Start'], PDO::PARAM_INT);
    $stmt->bindParam(":endName", $_POST['Slut'], PDO::PARAM_INT);
    $stmt->execute();
}
      
?>
</div>

<div class="w3-container">
    <h3>Utskrift av rapporter</h3>
    <table border="1">
      <?php   
        echo "<tr>";
          echo "<th>reportID</th>"; 
          echo "<th>newEntID</th>"; 
          echo "<th>newStartDate</th>"; 
          echo "<th>newWorkDate</th>"; 
          echo "<th>newRating</th>"; 
          echo "<th>newUnderlay</th>"; 
          echo "<th>newEdges</th>"; 
          echo "<th>newGrip</th>"; 
          echo "<th>newDepth</th>";
          echo "<th>kommentar</th>";
          echo "<th>sträcka</th>";  
          echo "</tr>";

        foreach($pdo->query( 'SELECT * FROM Reporting;' ) as $row){
          //echo "<tr><td>";
          //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
          echo "<tr>";
          echo "<td>".$row['reportID']."</td>";
          echo "<td>".$row['entID']."</td>";
          echo "<td>".$row['startDate']."</td>";
          echo "<td>".$row['workDate']."</td>";
          echo "<td>".$row['rating']."</td>";
          echo "<td>".$row['underlay']."</td>";
          echo "<td>".$row['edges']."</td>";
          echo "<td>".$row['grip']."</td>";
          echo "<td>".$row['depth']."</td>";
          echo "<td>".$row['comment']."</td>";
          echo "<td>".$row['name']."</td>";
          ?>
          <td class="Report-delete">
            <form action='<?php $_PHP_SELF ?>' method='POST'>
              <input type="hidden" name="deleteReport" value="<?php echo $row['reportID']; ?>">
              <input class="HoverButton" type="submit" name="delReport" value="Delete">
            </form>
          </td>

          <td class="Report-Store">
            <form action='backend_report.php?reportID="<?php echo $Report['reportID']; ?>"' method='POST'>
              <input type="hidden" name="storeReport" value="<?php $row['reportID']; ?>">
              <input class="HoverButton2" type="submit" name="storeReport" value="Store">
            </form>
          </td>
        <?php
          echo "</tr>";  
          }
      ?>
    </table>
</div>
<?php
  if(isset($_POST['delReport'])){
  $deletedReport = $_POST['deleteReport'];
  $sql = "DELETE FROM Report WHERE reportID = $deletedReport" ;
  $sql = "DELETE FROM ReportSubPlace WHERE reportID = $deletedReport" ;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
    }
?>
<?php
if(isset($_POST['storeReport'])){
  $querystring='INSERT INTO StoredReports (reportID, entID, startDate, workDate, rating, underlay, edges, grip, depth, comment, name) VALUES (:reportID, :entID, :startDate, :workDate, :rating, :underlay, :edges, :grip, :depth, :comment, :name);';
    $stmt = $pdo->prepare($querystring);
    $stmt->bindParam(":reportID", $row['reportID'], PDO::PARAM_INT);
    $stmt->bindParam(":entID", $row['entID'], PDO::PARAM_INT);
    $stmt->bindParam(":startDate", $row['startDate'], PDO::PARAM_STR);
    $stmt->bindParam(":workDate", $row['workDate'], PDO::PARAM_STR);
    $stmt->bindParam(":rating", $row['rating'], PDO::PARAM_INT);
    $stmt->bindParam(":underlay", $row['underlay'], PDO::PARAM_INT);
    $stmt->bindParam(":edges", $row['edges'], PDO::PARAM_INT);
    $stmt->bindParam(":grip", $row['grip'], PDO::PARAM_INT);
    $stmt->bindParam(":depth", $row['depth'], PDO::PARAM_INT);
    $stmt->bindParam(":comment", $row['comment'], PDO::PARAM_STR);
    $stmt->bindParam(":name", $row['name'], PDO::PARAM_INT);
    $stmt->execute();
    }
?>
<div class="w3-container">
    <h3>Utskrift av rapporter</h3>
    <table border="1">
      <?php   
        echo "<tr>";
          echo "<th>reportID</th>"; 
          echo "<th>newEntID</th>"; 
          echo "<th>newStartDate</th>"; 
          echo "<th>newWorkDate</th>"; 
          echo "<th>newRating</th>"; 
          echo "<th>newUnderlay</th>"; 
          echo "<th>newEdges</th>"; 
          echo "<th>newGrip</th>"; 
          echo "<th>newDepth</th>";
          echo "<th>kommentar</th>";
          echo "<th>sträcka</th>";  
          echo "</tr>";
        foreach($pdo->query( 'SELECT * FROM StoredReports;' ) as $row){
          //echo "<tr><td>";
          //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
          echo "<tr>";
          echo "<td>".$row['reportID']."</td>";
          echo "<td>".$row['entID']."</td>";
          echo "<td>".$row['startDate']."</td>";
          echo "<td>".$row['workDate']."</td>";
          echo "<td>".$row['rating']."</td>";
          echo "<td>".$row['underlay']."</td>";
          echo "<td>".$row['edges']."</td>";
          echo "<td>".$row['grip']."</td>";
          echo "<td>".$row['depth']."</td>";
          echo "<td>".$row['comment']."</td>";
          echo "<td>".$row['name']."</td>";
}
?>
</table>
</div>
*/