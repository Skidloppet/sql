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
Här kan man skriva kommentarer..



FÅR INTE INSERTEN ATT FUNGERA!



Nedanför kan man skriva php kod..
-->

<?php
include'connect.php';
?>

<div>
	<h3>Ny kundkommentar</h3>
	<form action='<?php $_PHP_SELF ?>' method='POST'>
		<textarea rows="5" cols="70" name="comment" placeholder="freetext comment"></textarea>
		</br>
		<input type="text" name="alias" placeholder="Alias..">
	    <select size='1' name='startName'>
	    	<option selected="selected"> Choose startingpoint </option>
			    <?php    
			    foreach($pdo->query( 'SELECT * FROM SubPlace where name<"21" ORDER BY name;' ) as $row){
			        echo '<option value="'.$row['name'].'">';
				    echo $row['realName'];      
				    echo '</option>';
			  	    }    
			    ?>
	    </select>

	    <select size='1' name='endName'>
	    	<option selected="selected"> Choose endingpoint </option>
			    <?php    
			    foreach($pdo->query( 'SELECT * FROM SubPlace where name<"21" ORDER BY name;' ) as $row){
			        echo '<option value="'.$row['name'].'">';
				    echo $row['realName'];      
				    echo '</option>';
			  	    }    
			    ?>
	    </select>

		<button type="submit" name="CreateComment">SEND COMMENT</button>
	</form>


<?php
	# skapa ett errormedelande vid fel input (inget alias, kommentar över 1024 tecken, inget start/slut)

	if(isset($_POST['CreateComment'])){

    $sql = "CALL _NewComment(:newComment, :newAlias, now(), :startName, :endName);";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":newComment", $_POST['comment'], PDO::PARAM_STR);
    $stmt->bindParam(":newAlias", $_POST['alias'], PDO::PARAM_STR);
    $stmt->bindParam(":startName", $_POST['startName'], PDO::PARAM_INT);
    $stmt->bindParam(":endName", $_POST['endName'], PDO::PARAM_INT);
    $stmt->execute();
	}  
?>
</div>

<div>
	<h3>Utskrift av kommentarer</h3>
    <table>
	    <?php  	
	    		echo "<tr>";
		        echo "<th>commentID</th>"; 
		        echo "<th>comment</th>"; 
		        echo "<th>alias</th>"; 
		        echo "<th>date</th>"; 
		        echo "</tr>";

		      foreach($pdo->query( 'SELECT * FROM Comment;' ) as $row){
		        //echo "<tr><td>";
		        //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
		        echo "<tr>";
		        echo "<td>".$row['commentID']."</td>";
		        echo "<td>".$row['comment']."</td>";
		        echo "<td>".$row['alias']."</td>";
		        echo "<td>".$row['date']."</td>";
		        echo "</tr>";  
		    }
	      ?>
    <table>
</div>

</body>
</html>