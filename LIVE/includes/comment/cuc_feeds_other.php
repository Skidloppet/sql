<!DOCTYPE html>
<?php
include'../connect.php';
?>

 

<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:lightblue; border-style: solid; border-width: 5px;">
  <div class="w3-threethird">
      <h5>Kund Kommentarer!</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <tr>
          <tr>
          <th><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></th>
          <th>Alias</th>
		  <th>Påverkade sträckor</th>
          <th>Betyg</th>
		  <th>Kommentar</th>
		  <th>Datum</th>
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
        }
        ?>   
      </table>
    </div>

  </div>
  </div>
  </div>
