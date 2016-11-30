<?php
include 'connect.php';	
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

<div class="w3-row-padding" style="margin:0 -16px">
    <div class="w3-threethird">
      <h5>Kundkommentarer</h5>
      <table class="w3-table w3-striped w3-white">
        <tr>
          <th><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></th>
          <th>Alias</th>
          <th>betyg</th>
		  <th>kommentar</th>
		  <th>datum</th>
          <th>Ta bort</th>
          <th>Arkivera</th>
        </tr>        
        <?php     

        foreach($pdo->query( 'SELECT * FROM commenta order by commentID desc;' ) as $row){
          echo "<tr><td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
          echo "<td>".$row['alias']."</td>";
          echo "<td>".$row['grade']."</td>";
          echo "<td>".$row['kommentar']."</td>";
          echo "<td>".$row['date']."</td>";
          echo "<td><a href='backend_wo.php?orderID=".$row['orderID']."'>Ta bort</a></td>";
          echo "<td><a href='backend_wo.php?orderID2=".$row['orderID']."'>logga</a></td>";
          echo "</tr>";  
        }
        ?>   
      </table>
    </div>


  </div>