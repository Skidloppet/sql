<!DOCTYPE html>
<?php
include'../connect.php';
?>

 

<!--
if(isset($_GET['commentID'])){
 $querystring='DELETE FROM Commenta WHERE commentID = :commentID';
 $stmt = $pdo->prepare($querystring);
 $stmt->bindParam(':commentID', $_GET['CommentID'], PDO::PARAM_INT);
 $stmt->execute();
 echo "kommentar borttagen";

}
-->
    <?php
  if(isset($_POST['commentID'])){
  $sql = "DELETE FROM Commenta WHERE commentID = :commentID";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':commentID', $_POST['commentID'], PDO::PARAM_INT);
  $stmt->execute();

    }
  ?>
  
<div class="w3-row-padding" style="border-color:lightblue; border-style: solid; border-width: 5px;">
  <div class="w3-threethird">
      <h3>Kund Kommentarer</h3>
      <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <tr>
          <tr>
          <th><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></th>
          <th>Alias</th>
		  <th>Påverkade sträckor</th>
          <th>Betyg</th>
		  <th>Kommentar</th>
		  <th>Datum</th>
		  <th></th>
                
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
 
        
        ?>  
		   <td class="comment-delete">
		   <form id="cucdel<?php echo $row['commentID']; ?>">
		   <input type="hidden" name="commentID" value="<?php echo $row['commentID']; ?>">
           <button type="button" onclick="SendForm('comments', 'comments', 'cucdel<?php echo $row['commentID']; ?>');">radera</button>
	       </form>

           </td>
		</tr>
		   
		<?php
        }
        ?>
		
      </table>
    </div>
</div>

