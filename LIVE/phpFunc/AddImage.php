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
Kod för att spara bilder och ladda upp bilder i/från databas
-->


<?php
include'connect.php';
?>

<form method="POST" action="<?php $_PHP_SELF ?>" enctype="multipart/form-data">
	<input type="file" name="newImage" />
	<input type="submit" name="submit_image" value="Upload" />
</form>

<?php

$upload_image=isset($_FILES["newImage"][ "submit_image" ]);

// Välj en mapp att spara bilderna i!
$folder="/images/";

move_uploaded_file (isset($_FILES["newImage"][" tmp_name "]), "$folder".isset($_FILES[" newImage "][" name "]));

$insert_path="INSERT INTO img (name, path) VALUES('$folder','$upload_image')";

//$var=
$stmt = $pdo->query($insert_path);

?>

<?php

$select_path="select * from img";

//$var=
$pdo->query($select_path);
//$stmt = $pdo->prepare($var);
$stmt = $pdo->query($select_path);
while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
	$image_name=$row["name"];
	$image_path=$row["path"];

	echo "img src=".$image_path."/".$image_name." width=100 height=100";
}
/*while ($row=mysql_fetch_array($pdo)) {
	$image_name=$row["name"];
	$image_path=$row["imagepath"];

	echo "img src=".$image_path."/".$image_name." width=100 height=100";
}
*/
/*
$imageName=$_FILES["newImage"]["name"];

$imagetmp=addslashes(file_get_contents($_FILES["newImage"]["tmp_name"]));

$insert_image="INSERT INTO img VALUES('$imagetmp', '$imageName')";

mysql_query($insert_image)
*/
?>
</div>

</body>
</html>