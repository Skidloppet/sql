﻿<!DOCTYPE html>
<?php
include'../connect.php';
SESSION_START();
$id = $_SESSION['id'];
$em = $_SESSION['email'];
$WOO = $_SERVER["SCRIPT_NAME"];
?>

<div class="w3-container" style="padding-left:8px">
  <div class="w3-row-padding w3-margin-bottom">
   <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id23').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-indigo w3-padding-16">
      <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3><br></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Skapa ny entrepenör användare</h4>
    </div>
  </div>
  <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id24').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-indigo w3-padding-16">
      <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3><br></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Skapa ny skidloppet användare</h4>
    </div>
  </div>

  <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id21').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-indigo w3-padding-16">
      <div class="w3-left"><i class="fa fa-cubes w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3><br></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Ändra roll för skidloppet användare</h4>
    </div>
  </div>

  <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id22').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-indigo w3-padding-16">
      <div class="w3-left"><i class="fa fa-phone w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3><br></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Nytt telefonnummer för entrepenör</h4>
    </div>
  </div>

</div>
</div>

<div class="w3-container" style="padding-left:8px">

  <div class="w3-container w3-section">
    <div class="w3-row-padding" style="margin:0 -16px">


      <!-- utskrift SKI -->
      <div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style="border-color:lightblue; border-style: solid; border-width: 5px;">
        <div class="w3-threethird">
          <!-- <div class="w3-container w3-section w3-green" style="z-index:4"> -->
          <h3>Utskrift av skidloppet användare</h3>
          <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <?php   
            echo "<tr>";
            echo "<th>Förnamn</th>"; 
            echo "<th>Efternamn</th>"; 
            echo "<th>mailadress</th>"; 
            echo "<th>typ</th>"; 
            echo "<th>tel-number</th>"; 
            echo "<th>reg-datum</th>"; 

            echo "</tr>";
            foreach($pdo->query( 'SELECT * FROM Ski;' ) as $row){
            //echo "<tr><td>";
            //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
              echo "<tr>";
              echo "<td>".$row['firstName']."</td>";
              echo "<td>".$row['lastName']."</td>";
              echo "<td>".$row['email']."</td>";
              echo "<td>".$row['type']."</td>";
              echo "<td>".$row['number']."</td>";
              echo "<td>".$row['regDate']."</td>";


              ?>
              <td class="Anv-delete">
               <form id="AnvDel<?php echo $row['skiID']; ?>">
                 <input type="hidden" name="skiID" value="<?php echo $row['skiID']; ?>">
                 <button type="button" onclick="SendForm('users', 'users', 'AnvDel<?php echo $row['skiID']; ?>');">radera</button>
               </form>
             </td>
           </tr>
           <?php
         }
         ?>

       </table>
     </div>
   </div>
   <?php
   if(isset($_POST['skiID'])){
    $deletedError = $_POST['skiID'];
    $sql = "DELETE FROM Ski WHERE skiID = $deletedError" ;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
  }
  ?>
  <!-- utskrift ent -->
  <div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style="border-color:lightblue; border-style: solid; border-width: 5px;">
    <div class="w3-threethird">
      <h3>Utskrift av entreprenörer</h3>
      <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">

        <?php   
        echo "<tr>";
        echo "<th>Förnamn</th>"; 
        echo "<th>Efternamn</th>"; 
        echo "<th>mailadress</th>"; 
        echo "<th>tel-number</th>"; 
        echo "<th>reg-datum</th>"; 

        echo "</tr>";
        foreach($pdo->query( 'SELECT * FROM Ent where entId > 2;' ) as $row){
            //echo "<tr><td>";
            //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
          echo "<tr>";
          echo "<td>".$row['firstName']."</td>";
          echo "<td>".$row['lastName']."</td>";
          echo "<td>".$row['email']."</td>";
          echo "<td>".$row['number']."</td>";
          echo "<td>".$row['regDate']."</td>";


          ?>
          <td class="Ent-delete">
           <form id="EntDel<?php echo $row['entID']; ?>">
             <input type="hidden" name="entID" value="<?php echo $row['entID']; ?>">
             <button type="button" onclick="SendForm('users', 'users', 'EntDel<?php echo $row['entID']; ?>');">radera</button>
           </form>
         </td>
       </tr>
       <?php
     }
     ?>
   </table>
 </div>
</div>
<?php
   if(isset($_POST['entID'])){
    $deletedEnt = $_POST['entID'];
    $sql = "DELETE FROM Ent WHERE entID = $deletedEnt" ;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
  }
?>
</table>
</div>
</div>
</div>







<!-- ny ski roll -->
<div id="id21" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id21').style.display='none'"
      class="w3-closebtn">&times;</span>
      <h3>Ändra roll för skidloppet användare</h3>
      <form id="nySki">
       <p>Användare *</p>
       <select name="skiID1">
        <?php    
        foreach($pdo->query( 'SELECT * FROM Ski ORDER BY skiID;' ) as $row){
          echo '<option value="'.$row['skiID'].'">';
          echo $row['firstName']." ".$row['lastName']." (".$row['type'].")";      
          echo '</option>';
        }    
        ?> 
      </select>


      <p>Ny Roll  *</p>
      <select name="type">
        <?php
        $sql = 'SHOW COLUMNS FROM Ski WHERE field="type"';
        $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
          print("<option>$option</option>");
        }
        ?>
      </select>
      <br></br>
      <button type="button" onclick="SendForm('users','users','nySki');" class="HoverButton" >Ändra</button>
    </form>

    <?php 
    if(isset($_POST['skiID1'])){
      $querystring='Call EditSki (:editSkiID, :newType);';
      $stmt = $pdo->prepare($querystring);
      $stmt->bindParam(':editSkiID', $_POST['skiID1']);
          # select's name �r skiID
      $stmt->bindParam(':newType', $_POST['type']);
          # select's name �r type
      $stmt->execute();

  #uppdaterar sidan och visar nya l�nen
        //  header("Location: hemsida5.php");
    }
    ?>

  </div>
</div>
</div>










<!-- nytt telnummer ent -->
<div id="id22" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id22').style.display='none'"
      class="w3-closebtn">&times;</span>
      Sätt nytt telefonnummer för entreprenör användare</h3>
      <form id="nyNum">
        <select size='1' name='entID1'>
          <option selected="selected"> Välj entreprenör </option>
          <?php    
          foreach($pdo->query( 'SELECT * FROM Ent ORDER BY entID;' ) as $row){
            echo '<option value="'.$row['entID'].'">';
            echo $row['firstName']." ".$row['lastName']." (".$row['number'].")";      
            echo '</option>';
          }    
          ?>
        </select>
        <input type="text" name="number">
        <button type="button" onclick="SendForm('users','users','nyNum');" class="HoverButton" >Ändra</button>

      </form>

      <?php 
      if(isset($_POST['entID1'])){
        $querystring='Call _newNumber (:_number, :_entID);';
        $stmt = $pdo->prepare($querystring);
        $stmt->bindParam(':_number', $_POST['number'], PDO::PARAM_INT);
          # select's name �r skiID
        $stmt->bindParam(':_entID', $_POST['entID1'], PDO::PARAM_INT);
          # select's name �r type
        $stmt->execute();

  #uppdaterar sidan och visar nya l�nen
        //  header("Location: hemsida5.php");
      }
      ?>
    </div>
  </div>
</div>

















<!-- ny ent anv -->
<div id="id23" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id23').style.display='none'"
      class="w3-closebtn">&times;</span>
      <form id="nyEnt">
        <h3>Skapa entrepenör</h3>
        <P>Förnamn</P>
        <input type="text" name="firstName" placeholder=".."></p>
        <P>Efternamn</P>
        <input type="text" name="lastName" placeholder=".."></p>
        <P>Emailadress</P>
        <input type="text" name="email1" placeholder=".."></p>
        <P>Telefonnummer ( <i>en extra nolla innan </i>)</P>
        <input type="text" name="number" placeholder="00703546851.."></p>
        <P>Lösenord</P>
        <input type="password" name="pass" placeholder=".."></p>
        <button type="button" onclick="SendForm('users','users','nyEnt');" class="HoverButton" >Skapa</button>

</form>
        <?php
             # skapa ett errormedelande vid fel input (email, number)

        if(isset($_POST['email1'])){

          $sql = "CALL CreateEnt(:pass, :firstName, :lastName ,:email, :number)";

          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(":pass", $_POST['pass'], PDO::PARAM_STR);
          $stmt->bindParam(":firstName", $_POST['firstName'], PDO::PARAM_STR);
          $stmt->bindParam(":lastName", $_POST['lastName'], PDO::PARAM_STR);
          $stmt->bindParam(":email", $_POST['email1'], PDO::PARAM_STR);
          $stmt->bindParam(":number", $_POST['number'], PDO::PARAM_INT);
          $stmt->execute();                  

        }     
        ?>
      </div>
    </div>
  </div>




  <!-- ny ski anv -->
  <div id="id24" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id24').style.display='none'"
        class="w3-closebtn">&times;</span>
        <form id="nySki">
          <h3>Skapa ny skidloppet användare</h3>
          <P>Förnamn</P>
          <input type="text" name="firstName" placeholder="firstname.."></p>
          <P>Efternamn</P>
          <input type="text" name="lastName" placeholder="surname.."></p>
          <P>Emailadress</P>
          <input type="text" name="email45" placeholder="email.."></p>      
          <P>Telefonnummer ( <i>en extra nolla innan </i>)</P>
          <input type="text" name="number" placeholder="00703546851"></p>           
           <p>Arbetsroll  *</p>
            <select name="type">
              <?php
              $sql = 'SHOW COLUMNS FROM Ski WHERE field="type"';
              $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
              foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
                print("<option>$option</option>");
              }
              ?>
            </select>
          <P>Lösenord</P>
          <input type="text" name="pass" placeholder="password.."></p>
          <button type="button" onclick="SendForm('users','users','nySki');" class="HoverButton" >Skapa</button>
        </form>


        <?php

        if(isset($_POST['email45'])){

          $sql = "CALL CreateSki(:pass, :firstName, :lastName, :email, :number, :type)";

          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(":pass", $_POST['pass'], PDO::PARAM_STR);
          $stmt->bindParam(":firstName", $_POST['firstName'], PDO::PARAM_STR);
          $stmt->bindParam(":lastName", $_POST['lastName'], PDO::PARAM_STR);
          $stmt->bindParam(":email", $_POST['email45'], PDO::PARAM_STR);
          $stmt->bindParam(":number", $_POST['number'], PDO::PARAM_INT);
          $stmt->bindParam(":type", $_POST['type'], PDO::PARAM_STR);
          $stmt->execute();
        }     
        ?>
      </div>