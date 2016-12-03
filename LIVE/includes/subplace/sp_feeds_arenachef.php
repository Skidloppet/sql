<!DOCTYPE html>

<?php
include'../connect.php';
?>


<div id="12" class="w3-container w3-blue">
  <h3>Alla av rapporter</h3>
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

      echo "<tr>";
    #echo "<td>".$row['name']."</td>";
    echo "<td>".$row['realName']."</td>";
    #echo "<td>".$row['entID']."</td>";
    echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
    #echo "<td>".$row['placeName']."</td>";
    echo "<td>".$row['length']."</td>";
    echo "<td>".$row['height']."</td>";
    echo "<td>".$row['fakesnow']."</td>";
    ?>

<?php /*
    <td class="subplace-update">
     <form id="FSnowUpdate<?php echo $row['name']; ?>">
       <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
       <button type="button" onclick="SendForm('subplace', 'subplace', 'FSnowUpdate<?php echo $row['name']; ?>');">FSnowUpdate</button>
     </form>

   </td>
   */
    ?>

</tr>
<?php
}
?>   
</table>
</div>
