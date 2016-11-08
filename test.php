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

Nedanför kan man skriva php kod..
-->

<?php
include'connect.php';
?>


<div>
	<h3>php kod för att skapa en Entrepenör</h3>
    <form action ='test.php' method='POST'>
	     <input type='text'  name='name' placeholder='Name..'></p>
	     <input type='text'  name='surname' placeholder='Surname..'></p>
	     <input type='text'  name='number' placeholder='Number..'></p>
	     <input type='text'  name='email' placeholder='email..'></p>
	     <input type='Password'  name='password' placeholder='Password..'></p>    
	     <p><button type='submit'>NEW ENT</button></p></form>
	
	<?php
	# deklarera variabler och tilldela värde från inputs.
	$NAME = $_POST['name'];
	$SURNAME = $_POST['surname'];
	$NUMBER = $_POST['number'];
	$EMAIL = $_POST['email'];
	$PASS = $_POST['password'];

	# pröva skriva ut för att se att allt är korrekt hittills
	echo $NAME."</Br>";
	echo $SURNAME."</Br>";
	echo $NUMBER."</Br>";
	echo $EMAIL."</Br>";
	echo $PASS."</Br>";

	# gör insert om endast namnet är ifyllt(ändra till alla fält?)
	# något fel med inserten samt att den kör if satsen även fast name inte är angivet!!
	if(isset($_POST['name'])){
			# skapa variabel för procedur och ange värden()
	        $querystring='Call CreateEnt (:pass,:firstName,:lastName,:email,:number);';
	        $stmt = $pdo->prepare($querystring);
	        $stmt->bindParam(':pass', $_POST['PASS']);
	        $stmt->bindParam(':firstName', $_POST['NAME']);
	        $stmt->bindParam(':lastName', $_POST['SURNAME']);
	        $stmt->bindParam(':email', $_POST['EMAIL']);
	        $stmt->bindParam(':number', $_POST['NUMBER']);
	        $stmt->execute();
	        echo "success";

		# uppdaterar sidan
	    # header("Location: test.php");
	    }
?>
</div>



<div>
	<h3>Utskrift av Entrepenörer</h3>
    <table>
	    <?php  
		        echo "<th>entID</th>"; 
		        echo "<th>name</th>"; 
		        echo "<th>surname</th>"; 
		      foreach($pdo->query( 'SELECT * FROM Ent;' ) as $row){
		        echo "<tr><td>";
		        echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
		        echo "<td>".$row['firstName']."</td>";
		        echo "<td>".$row['lastName']."</td>";
		        echo "</tr>";  
	      }
	    ?>
    </table>
</div>

</body>
</html>