<!DOCTYPE html>
<?php
include'../connect.php';
?>

<div class="w3-container" style="padding-left:31px">
<div id="12" class="w3-container w3-blue">
  <h3>Utskrift av registrerade felanmälningar</h3>
  <p>Senaste rapporterade felanmälningar överst i tabell.</p>
  <table class="w3-table w3-striped w3-white">
    <?php  
    echo "<tr>";
            #echo "<th style='background-color:white;'>Sträcka:</th>";
    echo "<th style='background-color:white;'>Sträcka:</th>"; 
            #echo "<th style='background-color:white;'>entID:</th>";
    echo "<th style='background-color:white;'>Entreprenör:</th>";
    echo "<th style='background-color:white;'>Beskrivning:</th>";
    echo "<th style='background-color:white;'>Skickad:</th>";
    echo "<th style='background-color:white;'>Typ:</th>";
    echo "<th style='background-color:white;'>Error ID:</th>";
    echo "</tr>";

    foreach($pdo->query( 'SELECT * 
      FROM Error, ErrorSubPlace, Ent, SubPlace
      WHERE Error.errorID = ErrorSubPlace.errorID AND Ent.entID = Error.entID and SubPlace.name = ErrorSubPlace.name 
      ORDER BY Error.errorID desc;
      ' ) as $row){
      echo "<tr>";
            #echo "<td>".$row['name']."</td>";
    echo "<td>".$row['realName']."</td>";
            #echo "<td>".$row['entID']."</td>";
    echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
    echo "<td>".$row['errorDesc']."</td>";
    echo "<td>".$row['sentDate']."</td>";
    echo "<td>".$row['type']."</td>";
    echo "<td>".$row['errorID']."</td>";
    ?>
    <td class="Error-delete">
     <form id="ErrDel<?php echo $row['errorID']; ?>">
       <input type="hidden" name="errorID" value="<?php echo $row['errorID']; ?>">
       <button type="button" onclick="SendForm('errorreport', 'errorreport', 'ErrDel<?php echo $row['errorID']; ?>');">radera</button>
     </form>

   </td>
 </tr>
 
 <?php
}
?>

</table>
<br><br>
</div>

<?php
if(isset($_POST['errorID'])){
  $deletedError = $_POST['errorID'];
  $sql = "DELETE FROM Error WHERE errorID = $deletedError" ;
  $sql = "DELETE FROM ErrorSubPlace WHERE errorId = $deletedError" ;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
}
?>
