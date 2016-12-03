<!DOCTYPE html>

<?php
include'../connect.php';
?>
<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
</script>


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

    <td>
      <form id="changeSubPlace">
        <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
        <select name='entID' class="js-example-basic-single">		
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
	  
    </td>
  </tr>
  <?php
}
?>   
</table>
</div>

<?php
echo "changeSubPlace $SubPlaceName";
# funk för att ändra ansvar på pågående order.
if(isset($_POST['name'])){
  $sql = "call _newResponsabilitySubPlace (:_entID,:_name)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":_entID", $_POST['entID'], PDO::PARAM_INT);
  $stmt->bindParam(":_name", $_POST['name'], PDO::PARAM_INT);
  $stmt->execute();
}    
?>
    <?php /*
    <td>
      <select id="entID" name='entID'>    
        <?php 
              # i varje rad av svar den skriver ut så skapas en lista med alla Ent förnamn&efternamn
              # sätter value till entrepenöresns ID 
        foreach ($pdo->query('SELECT * FROM Ent') as $row) {
          echo '<option value="'.$row['entID'].'">';
          echo $row['firstName']." ".$row['lastName'];
          echo "</option>";
        }
        ?>
      </select><p><button id="ButtonEntID" type="submit" name="newEnt">Sätt entrepenör ansvar</button></p>
    </form>
  </td>
  <?php
  echo "</td></tr>";  
}
?>   
</form>

</table>
</div>

<?php

if(isset($_POST['updateSubEnt'])){
  $querystring='UPDATE SubPlaceViewer SET
  entID = :newEnt
  WHERE
  name = :name';
  $stmt = $pdo->prepare($querystring);
  $stmt->bindParam(":newEnt", $_POST['newEnt'], PDO::PARAM_INT);
  $stmt->bindParam(":name", $TargetSubPlace, PDO::PARAM_INT);
  $stmt->execute();
}
*/
?>  

<!-- End page content -->
</div>
</div>
</div>
