<!DOCTYPE HTML>
<head>
<meta charset="utf-8">
<html>
<style>
body {
    background-color: papayawhip;
}
div{
  display: block; 
  float: left;
  background-color: gainsboro;
  margin: 20px;
  padding: 20px;
}
table, td, th{
  border:1px solid;
  text-align: center;
  margin: auto;
  border-collapse: collapse;
  padding:2px;

}
tr:hover {
    background-color: #ffff99;
}
</style>
</head>
<body>
<?php
include'connect.php';
?>
<!--
Här kan man skriva kommentarer..

Nedanför kan man skriva php kod..
-->
<?php
SESSION_START();
?>
  <div>
    <?php
    # print_r($_SESSION );
    # echo "<div>ids:".$_SESSION[0]." :wallas: ".$_SESSION[1]."</div>";

  if (isset($_SESSION['email'])) {
    echo "logged in as: ";
    echo $_SESSION['email']." role: ";
    echo $_SESSION['type'];
?>
      <div id='log'>
      <form action='logout.php'>
      <button>LOG OUT</button>
    </form>
    </div>
<?php
  }
  ?>

<div>
  <?php
      if (!isset($_SESSION['email'])) {
      ?>
      <h3>Här är all kod för ICKE inloggade</h3>
  <?php 
      } 
      elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'arenachef')) {
      ?>
      <h3>Här är all kod för ARENACHEFER</h3>  
  <?php
      }
      elseif (isset($_SESSION['email'])&&($_SESSION['type'] == 'other')) {
      ?>
      <h3>Här är all kod för OTHERS(Skidloppet)</h3>
  <?php 
      }
      elseif (isset($_SESSION['email'])&&($_SESSION['type'] > '1')) {
      ?>
      <h3>Här är all kod för ENT</h3>
  <?php
      }
 else{
  echo "if this message is showing your logged in as a hacker or smt";
 }
      ?>
 </div>    

</body>
</html>