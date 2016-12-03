<!DOCTYPE html>

<?php
include'../connect.php';
?>


<div id="12" class="w3-container w3-blue">
  <h3>Alla av rapporter</h3>
  <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
    <?php   
    echo "<tr>";
    echo "<th>name</th>"; 
    echo "<th>placeName</th>"; 
    echo "<th>Plats</th>"; 
    echo "<th>entID</th>"; 
    echo "<th>Entreprenör</th>"; 
    echo "<th>Längd:</th>"; 
    echo "<th>Höjd:</th>"; 
    echo "<th>Konstsnö:</th>"; 
    echo "<th>Nollställ konstsnö:</th>"; 
    echo "<th>Ändra ansvarig entrepenör:</th>"; 
    echo "</tr>";

    foreach ($pdo->query('
      SELECT *
      from SubPlaceViewer;
      ')as $row) {

      echo "<tr>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['placeName']."</td>";
    echo "<td>".$row['realName']."</td>";
    echo "<td>".$row['entID']."</td>";
    echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
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
   

   <td class="Change-Ent">
    <form id="changeSubPlace<?php echo $row['name']; ?>">
      <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
      <select name='entID'>    
        <?php 
        foreach ($pdo->query('SELECT * FROM Ent') as $row) {
          echo '<option value="'.$row['entID'].'">';
          echo $row['firstName']." ".$row['lastName'];
          echo "</option>";
        }
        ?>
      </select>
      <button type="button" onclick="SendForm('subplace', 'subplace', 'changeSubPlace<?php echo $row['name']; ?>');">update</button>
    </form>
*/
    ?>
    <td class="subplace-update">
     <form id="ChangeSubEnt<?php echo $row['name']; ?>">
       <input type="hidden" name="commentID" value="<?php echo $row['name']; ?>">
       <select id="ID<?php echo $row['entID']; ?>">    
        <?php 
        foreach ($pdo->query('SELECT * FROM Ent') as $row) {
          echo '<option value="'.$row['entID'].'">';
          echo $row['firstName']." ".$row['lastName'];
          echo "</option>";
        }
        ?>
      </select type="button" onclick="SendForm('subplace', 'subplace', 'ID<?php echo $row['entID']; ?>');">
      <button type="button" onclick="SendForm('subplace', 'subplace', 'ChangeSubEnt<?php echo $row['name']; ?>');">uppdatera</button>
    </form>

  </td>
</td>
</tr>
<?php
}
?>   
</table>
</div>

<?php
# funk för att ändra ansvar på pågående order.
if(isset($_POST['name'])){
  $sql = "call _newResponsabilitySubPlace (:_entID,:_name)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":_entID", $_POST['entID'], PDO::PARAM_INT);
  $stmt->bindParam(":_name", $_POST['name'], PDO::PARAM_INT);
  $stmt->execute();
}    
/*
if(isset($_POST['FSnowUpdate'])){
  $sql = "UPDATE SubPlace SET fakesnow = '0' WHERE name = :name";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_INT);
  $stmt->execute();
}
*/
?>  

<!-- End page content -->
</div>
</div>
</div>
