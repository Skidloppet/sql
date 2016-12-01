<!DOCTYPE html>
<?php
include'../connect.php';
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

<div id="1" class="w3-container w3-orange w3-section">
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
          echo "</tr>";  
        
        ?>  
		   <td class="comment-delete">
           <form action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method='POST'>
           <input type="hidden" name="deleteComment" value="<?php echo $row['commentID']; ?>">
           <input class="HoverButton" type="submit" name="delComment" value="Delete">
           </form>
           </td>
		   
		<?php
        echo "</tr>";  
        }
        ?>
		
      </table>
    </div>
    <?php
  if(isset($_POST['delComment'])){
  $deletedComment = $_POST['deleteComment'];
  $sql = "DELETE FROM Commenta WHERE commentID = $deletedComment" ;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
    }
  ?>
  </div>
  </div>
  </div>
