
 <?php
        	$pdo = new PDO('mysql:dbname=SlitABSkidloppet;host=localhost','sqllab','Tomten2009');
		    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		    $conn = mysqli_connect("localhost","sqllab","Tomten2009",'SlitABSkidloppet');
			if (!$conn) {
			die("Connection failed:".mysqli_connect_error());
} 
