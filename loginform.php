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
  else {
    ?>
     <div id='log'>
     <form action ='skidlogin.php' method='POST'>
     <input type='text'  name='email' placeholder='email..'></br>
     <input type='Password'  name='pass' placeholder='pass..'>
     <p><button type='submit'>LOGIN</button></p></form></div>
     </div>
     <?php
        }
      ?>
     

</body>
</html>