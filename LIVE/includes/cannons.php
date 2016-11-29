
    <!-- Header -->
    <?php
   include 'cannons/can_headerbox.php';
    ?>

    <div class="w3-container w3-section">
      <div class="w3-row-padding" style="margin:0 -16px">

        <div class="w3-threethird">
          <?php
          //include './backend_feeds.php';
          ?>
		  <br><br/>
		  <br><br/>
		  <br><br/>
        </div>
        <hr>

<div>
<h3>Lägg till snökanon</h3>
	<form action='<?php $_PHP_SELF ?>' method="post">
			<select size='1' name='state'>
			<option selected="selected"> status </option>
		<?php
			$sql = 'SHOW COLUMNS FROM Cannon WHERE field="state"';
			$row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
			foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
			 print("<option>$option</option>");
			}
				
		?>
	</select>
		<input type="text" name="subPlaceName" placeholder="plats.."></p>
		<input type="text" name="model" placeholder="modell.."></p>
		<input type="text" name="effect" placeholder="effekt.."></p>
		<input type="submit" value="Lägg till"/>
</form>

	<?php
	    if(isset($_POST['subPlaceName'])){
	        $sql="CALL NewCannon(:subPlaceName,:model,:state,:effect)";
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':subPlaceName', $_POST['subPlaceName'],PDO::PARAM_INT);
	        $stmt->bindParam(':model', $_POST['model'],PDO::PARAM_STR);
	        $stmt->bindParam(':state', $_POST['state'],PDO::PARAM_STR);
			$stmt->bindParam(':effect', $_POST['effect'],PDO::PARAM_INT);
	        $stmt->execute();
	    }
	?>
</div>

  <h3>Utskrift av snökanoner</h3>
    <table border="1">
      <?php  
        echo "<tr>";
        echo "<th style='background-color:white;'>Plats:</th>"; 
        echo "<th style='background-color:white;'>modell:</th>";
        echo "<th style='background-color:white;'>state:</th>";
        echo "<th style='background-color:white;'>effekt:</th>";
        echo "</tr>";


    foreach($pdo->query( 'SELECT * FROM Cannon;' ) as $row){
      echo "<tr>";
      echo "<td>".$row['subPlaceName']."</td>";
      echo "<td>".$row['model']."</td>";
      echo "<td>".$row['state']."</td>";
      echo "<td>".$row['effect']."</td>";
      echo "</tr>"; 
    }
?>
</table>
</div>


<<div class="w3-container w3-pink">
<h3>ändra snökanon</h3>
<form action='<?php $_PHP_SELF ?>' method='POST'>
	    <select size='1' name='cannonID'>
    	<option selected="selected"> välj kanon </option>
		    <?php    
		    foreach($pdo->query( 'SELECT * FROM Cannon ORDER BY cannonID;' ) as $row){
		        echo '<option value="'.$row['cannonID'].'">';
			    echo $row['cannonID'];      
			    echo '</option>';
		  	    }    
		    ?>
	    </select>
    <select size='1' name='subPlaceName'>
	<option selected="selected"> plats </option>
    			    <?php    
		    foreach($pdo->query( 'SELECT * FROM SubPlace ;' ) as $row){
		    	# GROUP BY G?R S? DET EJ BLIR DUBLETTER
		        echo '<option value="'.$row['subPlaceName'].'">';
			    echo $row['realName'];      
			    echo '</option>';
		  	    }    
		    ?>
	</select>
	
	<select size='1' name='state'>
	<option selected="selected"> status </option>
    <?php
			$sql = 'SHOW COLUMNS FROM Cannon WHERE field="state"';
			$row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
			foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
			  print("<option>$option</option>");
			}
				
		?>
	</select>
<input type="submit" value="Send" name="send">
<input type="reset"></form>

	<?php 
	    if(isset($_POST['send'])){
	        $querystring='Call AlterCannon (:cannonID, :subPlaceName, :state);';
	        $stmt = $pdo->prepare($querystring);
	        $stmt->bindParam(':cannonID', $_POST['cannonID']);
	        $stmt->bindParam(':subPlaceName', $_POST['subPlaceName']);
			$stmt->bindParam(':state', $_POST['state']);
	        $stmt->execute();

	    }
	?>
	
	  <h3>ändring snökanoner</h3>
    <table border="1">
      <?php  
        echo "<tr>";
        echo "<th style='background-color:grey;'>Plats:</th>"; 
        echo "<th style='background-color:grey;'>modell:</th>";
        echo "<th style='background-color:grey;'>state:</th>";
		echo "<th style='background-color:grey;'>cannonID:</th>";

        echo "</tr>";


    foreach($pdo->query( 'SELECT * FROM Cannon;' ) as $row){
      echo "<tr>";
      echo "<td>".$row['subPlaceName']."</td>";
      echo "<td>".$row['model']."</td>";
      echo "<td>".$row['state']."</td>";
	  echo "<td>".$row['cannonID']."</td>";

      echo "</tr>"; 
    }
?>
</table>
</div>


<!-- Funkar ej -->
<div class="w3-container w3-purple">
<h3>NEW CANNON ORDER</h3>
<table border="1">
	<th>CannonID</th>
	<th>CannonModel</th>
	<th>Cannon current position</th>
	<th>Cannon current status</th>
	<th>Cannon effect</th>
	<th>Select </th>
	<tr>
		<?php
	    foreach($pdo->query( 'SELECT cannonID, model, state, effect, realName  FROM Cannon, SubPlace where SubPlace.name = Cannon.subPlaceName;') as $row){
		    echo "<tr>";
		    echo "<td>".$row['cannonID']."</td>";
		    echo "<td>".$row['model']."</td>";
		    echo "<td>".$row['realName']."</td>";
		    echo "<td>".$row['state']."</td>";
		    echo "<td>".$row['effect']."</td>";
	    	echo '<form><th><input type="checkbox" name="selected" value="'.$row["cannonID"].'"></th>';
	        echo "</tr>";
	    }
		?>
	</tr>
</table>

	
	
		<p>Change status</p>
    	<select id="selecten"> 
  	        <option value="as">select status</option>
  	        <option name="status" value="on">on</option>
    	    <option name="status" value="off">off</option>
        	<option name="status" value="unplugged">unplugged</option>
            <option name="status" value="broken">broken</option>	   
        	</select>
		
	<div>
   		<p>Change location</p>
        <select>
        	<option value="selected">select track</option>
		    <?php  
		 	   foreach($pdo->query( 'SELECT * FROM SubPlace where SubPlace.placeName = "Delstrackor" or SubPlace.placeName = "Garage";' ) as $row){
		        echo '<option name="name" value="'.$row['name'].'">';
			    echo $row['realName'];      
			    echo '</option>'; 
				} 
			?> 
        </select> 
<br></br>
			<p>info till ent</p>
			<form action='backend_cannon.php' method='POST'>
			<textarea rows="3" cols="70" name="info" placeholder="info..."></textarea>	
		
		</div>

	<div>
   		<p>Set responsibility (* default = split between owners of tracks)</p>
        <select class='select1'>
        	<option id="select1">default</option>
		    <?php    
		    foreach($pdo->query( 'SELECT * FROM Ent; ' ) as $row){
		        echo '<option name="entID"value="'.$row['entID'].'">';
			    echo $row['firstName']." ".$row['lastName'];      
			    echo '</option>'; } ?> 
        </select>     
 	<input type="submit" name="send">

 <?php

	if(isset($_POST['send'])){
    $sql = "call _newCannonOrder (:cannonID,:name,:entID,:newStatus,:info);";
		
		echo $_POST['selected'];
		echo $_POST['cannonID'];
		echo "wolo";
		echo $_POST['name'];

	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(":cannonID", $_POST['selected'], PDO::PARAM_INT);
	    $stmt->bindParam(":name", $_POST['selected'], PDO::PARAM_INT);
	    $stmt->bindParam(":entID", $_POST['entID'], PDO::PARAM_INT);
	    $stmt->bindParam(":newStatus", $_POST['state'], PDO::PARAM_STR);
		$stmt->bindParam(":info", $_POST['info'], PDO::PARAM_STR);
	    $stmt->execute();
	}
	    
?>
	</div>
</div>

<div class="w3-container ">
	<h3>Utskrift av CANNONdfsdfsd ORDERS!(CannonSubPlace)</h3>
    <table
	 <table border="1">
	    <?php  
				echo "<tr>";
		        echo "<th>cannonID</th>"; 
		        echo "<th>name</th>";
		        echo "<th>entID</th>";
		        echo "<th>newStatus</th>";
				echo "<th>info</th>";
				echo "</tr>";

		      foreach($pdo->query( 'select * from CannonSubPlace;' ) as $row){
		        echo "<tr>";
		        echo "<td>".$row['cannonID']."</td>";
		        echo "<td>".$row['name']."</td>";
		        echo "<td>".$row['entID']."</td>";
		        echo "<td>".$row['newStatus']."</td>";
				echo "<td>".$row['info']."</td>";
		        echo "</tr>";  
	      }
	    ?>
    </table>
</div>