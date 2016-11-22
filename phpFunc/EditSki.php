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
<!--
-->

<?php
include'connect.php';
?>


<div>
	<h3>Set new role 4 Ski</H4>
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
		    	# GROUP BY GÖR SÅ DET EJ BLIR DUBLETTER
		        echo '<option value="'.$row['type'].'">';
			    echo $row['type'];      
			    echo '</option>';
		  	    }    
		    ?>
	</select>
<input type="submit" value="Send" name="send">
<input type="reset">

	<?php 
	    if(isset($_POST['send'])){
	        $querystring='Call EditSki (:editSkiID, :newType);';
	        $stmt = $pdo->prepare($querystring);
	        $stmt->bindParam(':editSkiID', $_POST['skiID']);
	        # select's name är skiID
	        $stmt->bindParam(':newType', $_POST['type']);
	        # select's name är type
	        $stmt->execute();

	#uppdaterar sidan och visar nya lönen
	      //  header("Location: hemsida5.php");
	    }
	?>
</div>



</body>
</html>