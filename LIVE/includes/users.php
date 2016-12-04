<!DOCTYPE html>
<html>
<?php
include'../connect.php';
SESSION_START();
$id = $_SESSION['id'];
$em = $_SESSION['email'];
$WOO = $_SERVER["SCRIPT_NAME"];
?>

<div class="w3-row-padding w3-margin-bottom">
 <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id21').style.display='block'">
  <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-green w3-padding-16">
    <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
    <div class="w3-right">
      <h3><br></h3>
    </div>
    <div class="w3-clear"></div>
    <h4>Ändra roll för skidloppet användare</h4>
  </div>
</div>
</div>


    <!-- utskrift SKI -->
<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style="border-color:lightblue; border-style: solid; border-width: 5px;">
<div class="w3-threethird">
<!-- <div class="w3-container w3-section w3-green" style="z-index:4"> -->
<h3>Skidloppet-anställda</h3>
     <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <?php   
          echo "<tr>";
            echo "<th>skiID</th>"; 
            echo "<th>FirstName</th>"; 
            echo "<th>LastName</th>"; 
            echo "<th>emailadress</th>"; 
            echo "<th>type</th>"; 
            echo "<th>tel-number</th>"; 
            echo "<th>password</th>"; 
            echo "<th>regDate</th>"; 

            echo "</tr>";
          foreach($pdo->query( 'SELECT * FROM Ski;' ) as $row){
            //echo "<tr><td>";
            //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
            echo "<tr>";
            echo "<td>".$row['skiID']."</td>";
            echo "<td>".$row['firstName']."</td>";
            echo "<td>".$row['lastName']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['type']."</td>";
            echo "<td>".$row['number']."</td>";
            echo "<td>".$row['password']."</td>";
            echo "<td>".$row['regDate']."</td>";
            echo "</tr>";  
        }
        ?>
      </table>
</div>
</div>
    <!-- utskrift ent -->
<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style="border-color:lightblue; border-style: solid; border-width: 5px;">
<div class="w3-threethird">
<h3>Utskrift av feta entreprenörer</h3>
<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">

      <?php   
          echo "<tr>";
            echo "<th>entID</th>"; 
            echo "<th>FirstName</th>"; 
            echo "<th>LastName</th>"; 
            echo "<th>emailadress</th>"; 
            echo "<th>tel-number</th>"; 
            echo "<th>password</th>"; 
            echo "<th>regDate</th>"; 

            echo "</tr>";
          foreach($pdo->query( 'SELECT * FROM Ent;' ) as $row){
            //echo "<tr><td>";
            //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
            echo "<tr>";
            echo "<td>".$row['entID']."</td>";
            echo "<td>".$row['firstName']."</td>";
            echo "<td>".$row['lastName']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['number']."</td>";
            echo "<td>".$row['password']."</td>";
            echo "<td>".$row['regDate']."</td>";
            echo "</tr>";  
        }
        ?>
      </table>
</div>
</div>



 
<!-- FUNKAR EJ JOBBA VIDARE  -->
    <!-- ny ski roll -->
	<div id="id21" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id21').style.display='none'"
      class="w3-closebtn">&times;</span>
      <h3>Ändra roll för skidloppet användare</h3>
      <form id="nySki">
	   <p>Användare *</p>
	   <select name="skiID">
	      <?php    
          foreach($pdo->query( 'SELECT * FROM Ski ORDER BY skiID;' ) as $row){
            echo '<option value="'.$row['skiID'].'">';
            echo $row['firstName']." ".$row['lastName']." (".$row['type'].")";      
            echo '</option>';
          }    
          ?> 
        </select>
		
		<p>Ny roll *</p>
	   <select name="roll">
	   <?php    
          foreach($pdo->query( 'SELECT type FROM Ski GROUP BY type;' ) as $row){
          # Denna bör ändras då den inte är fullt funktionell.
            echo '<option value="'.$row['type'].'">';
            echo $row['type'];      
            echo '</option>';
          }    
          ?>
        </select>
		<br></br>
	  <button type="button" onclick="SendForm('user','user','nySki');" class="HoverButton" >Ändra</button>
	  </form>
	  </div>
	  </div>
	  </div>


    <div class="w3-container w3-section w3-cyan">
      <h3>Sätt ny roll för en Skidloppet användare</h3>
      <h4>fel när det inte finns någon av en viss typ(då försvinner alternativet)</h4>
      <form action='<?php $_PHP_SELF ?>' method='POST'>
        <select size='1' name='skiID'>
          <option selected="selected"> Choose employee </option>
          <?php    
          foreach($pdo->query( 'SELECT * FROM Ski ORDER BY skiID;' ) as $row){
            echo '<option value="'.$row['skiID'].'">';
            echo $row['firstName']." ".$row['lastName']." (".$row['type'].")";      
            echo '</option>';
          }    
          ?>
        </select>
        <select size='1' name='type'>
          <option selected="selected"> New role </option>
          <?php    
          foreach($pdo->query( 'SELECT type FROM Ski GROUP BY type;' ) as $row){
          # Denna bör ändras då den inte är fullt funktionell.
            echo '<option value="'.$row['type'].'">';
            echo $row['type'];      
            echo '</option>';
          }    
          ?>
        </select>
        <input type="submit" value="Send" name="send">
        <input type="reset">
        </form>

        <?php 
        if(isset($_POST['send'])){
          $querystring='Call EditSki (:editSkiID, :newType);';
          $stmt = $pdo->prepare($querystring);
          $stmt->bindParam(':editSkiID', $_POST['skiID']);
          # select's name �r skiID
          $stmt->bindParam(':newType', $_POST['type']);
          # select's name �r type
          $stmt->execute();

  #uppdaterar sidan och visar nya l�nen
        //  header("Location: hemsida5.php");
        }
        ?>
      </div>




       <div class ="w3-container w3-section w3-red">
      <h3>Sätt nytt tel-nummer för en entreprenör användare</h3>
      <form action='<?php $_PHP_SELF ?>' method='POST'>
        <select size='1' name='entID'>
          <option selected="selected"> välj entreprenör </option>
          <?php    
          foreach($pdo->query( 'SELECT * FROM Ent ORDER BY entID;' ) as $row){
            echo '<option value="'.$row['entID'].'">';
            echo $row['firstName']." ".$row['lastName']." (".$row['number'].")";      
            echo '</option>';
          }    
          ?>
        </select>
        <input type="text" name="number">
        <input type="submit" value="Send" name="send">
        <input type="reset">
        </form>

        <?php 
        if(isset($_POST['send'])){
          $querystring='Call _newNumber (:_number, :_entID);';
          $stmt = $pdo->prepare($querystring);
          $stmt->bindParam(':_number', $_POST['number'], PDO::PARAM_INT);
          # select's name �r skiID
          $stmt->bindParam(':_entID', $_POST['entID'], PDO::PARAM_INT);
          # select's name �r type
          $stmt->execute();

  #uppdaterar sidan och visar nya l�nen
        //  header("Location: hemsida5.php");
        }
        ?>
      </div>


      <!-- ny ent anv�ndare -->
      <div class="w3-container w3-section w3-blue">
        <h3>Create new Ent</h3>
        <form action='<?php $_PHP_SELF ?>' method='POST'>
          <input type="text" name="firstName" placeholder="firstname.."></p>
          <input type="text" name="lastName" placeholder="surname.."></p>
          <input type="text" name="email" placeholder="email.."></p>
          <input type="text" name="number" placeholder="number.."></p>
          <input type="password" name="pass" placeholder="password.."></p>
          <p><button type="submit" name="CreateEnt" id="CreateEnt">NEW ENT</button></p></form>


          <?php
             # skapa ett errormedelande vid fel input (email, number)

          if(isset($_POST['CreateEnt'])){

            $sql = "CALL CreateEnt(:pass, :firstName, :lastName ,:email, :number)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":pass", $_POST['pass'], PDO::PARAM_STR);
            $stmt->bindParam(":firstName", $_POST['firstName'], PDO::PARAM_STR);
            $stmt->bindParam(":lastName", $_POST['lastName'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
            $stmt->bindParam(":number", $_POST['number'], PDO::PARAM_INT);


  try{ 
            $stmt->execute();                  
        }catch (PDOException $e){
            if($e->getCode()=="23000"){
                echo "Duplicate company code!";
            }else{
                echo "<p>".$e->getMessage()."</p>";
            }
        }

          }     
          ?>
        </div>


        <!-- ny ski anv�ndare -->
        <div class="w3-container w3-section w3-orange">
          <h3>Create new Ski</h3>
          <form action='<?php $_PHP_SELF ?>' method='POST'>
            <input type="text" name="firstName" placeholder="firstname..">
            <input type="text" name="lastName" placeholder="surname..">
            <input type="text" name="email" placeholder="email..">
            <input type="text" name="number" placeholder="number..">
            <input type="text" name="type" placeholder="type..">
            <input type="text" name="pass" placeholder="password..">
            <button type="submit" name="CreateSki" id="CreateSki">NEW SKI</button>
          </form>


          <?php

          if(isset($_POST['CreateSki'])){

            $sql = "CALL CreateSki( :pass, :firstName, :lastName , :email, :number, :type)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":pass", $_POST['pass'], PDO::PARAM_STR);
            $stmt->bindParam(":firstName", $_POST['firstName'], PDO::PARAM_STR);
            $stmt->bindParam(":lastName", $_POST['lastName'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
            $stmt->bindParam(":number", $_POST['number'], PDO::PARAM_INT);
            $stmt->bindParam(":type", $_POST['type'], PDO::PARAM_STR);
            $stmt->execute();
          }     
          ?>
        </div>
