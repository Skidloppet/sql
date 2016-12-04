<!DOCTYPE html>

<?php
include'../connect.php';
?>


<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:lightblue; border-style: solid; border-width: 5px;">
  <div class="w3-threethird">
  <h3>Alla delsträckor:</h3>
  <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
    <?php   
    echo "<tr>";
    #echo "<th>name</th>"; 
    echo "<th>Plats</th>"; 
    #echo "<th>entID</th>"; 
    echo "<th>Entreprenör</th>"; 
    #echo "<th>Typ</th>"; 
    echo "<th>Längd:</th>"; 
    echo "<th>Höjd:</th>"; 
    echo "<th>Konstsnö:</th>"; 
    echo "</tr>";

    foreach ($pdo->query('
      SELECT *
      from SubPlaceViewer;
      ')as $row) {

      $luck = $row ['entID'];
      echo "<tr>";
    #echo "<td>".$row['name']."</td>";
    echo "<td>".$row['realName']."</td>";
    #echo "<td>".$row['entID']."</td>";
    echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
    #echo "<td>".$row['placeName']."</td>";
    echo "<td>".$row['length']." km</td>";
    echo "<td>".$row['height']." m ö.h.</td>";
    echo "<td>".$row['fakesnow']." m&#179</td>";
    ?>
  </tr>
  <?php
}
?> 
</table><br><br>
</div>
</div>
