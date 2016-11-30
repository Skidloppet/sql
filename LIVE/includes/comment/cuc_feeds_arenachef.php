<!DOCTYPE html>
<?php
include'../connect.php';
SESSION_START();
$id = $_SESSION['id'];
$em = $_SESSION['em'];

?>

 
<?php

if(isset($_GET['commentID'])){
 $querystring='DELETE FROM Commenta WHERE commentID = :commentID';
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':commentID', $_GET['CommentID'], PDO::PARAM_INT);
 $stmt->execute();
 echo "kommentar borttagen";
}
?>

<div class="w3-container w3-orange w3-section">
    <div class="w3-container w3-section">
    <div class="w3-row-padding" style="margin:0 -16px"
  <div class="w3-row-padding" style="margin:0 -16px">
    <div class="w3-threethird">
      <h5>Kund Kommentarer!</h5>
      <table class="w3-table w3-striped w3-white">
        <tr>
          <tr>
          <th><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></th>
          <th>Alias</th>
		  <th>Påverkade sträckor</th>
          <th>Betyg</th>
		  <th>Kommentar</th>
		  <th>Datum</th>
		  <th></th>
        </tr>        
        <?php     

        foreach($pdo->query( 'SELECT * FROM Commenta order by commentID desc;' ) as $row){
			$luck = $row ['commentID'];
          echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
          echo "<td>".$row['alias']."</td>";
		  echo "<td>";
		  foreach($pdo->query( 'select realName from SubPlace, CommentSubPlace where SubPlace.name = CommentSubPlace.name and CommentSubPlace.commentID = '.$luck.';' ) as $brow){;
		  echo $brow['realName']."</br>";
		  };
		  echo "</td>";
          echo "<td>".$row['grade']." / 5 </td>";
          echo "<td>".$row['kommentar']."</td>";
          echo "<td>".$row['date']."</td>";
          echo "<td><a href='backend.php?commentID=".$row['commentID']."'>Radera</a></td>";
          echo "</tr>";  
        }
        ?>   
      </table>
    </div>

  </div>
  </div>
  </div>
