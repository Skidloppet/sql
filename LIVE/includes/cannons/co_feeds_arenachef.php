
<?php
include '../connect.php';	
?>	

<h2>Snökanoner</h2>

<div class="w3-container">
  <div class="w3-row-padding">
    <div class="w3-twothird w3-right">

     <h5>Utskrift av snökanoner</h5>
     <table class="w3-table w3-striped w3-white">
      <th>CannonID</th>
      <th>CannonModel</th>
      <th>Cannon current position</th>
      <th>Cannon current status</th>
      <th>Cannon effect</th>
      <th>Select </th>
      <tr>

<!--
CREATE PROCEDURE _newCannonOrder (
cannonID smallint,
name smallint,
entID smallint,
info varchar (1024),
newStatus enum('on','off','unplugged','broken'))

-->
<form name="fruitcheckbox" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <?php
        foreach($pdo->query( 'SELECT cannonID, model, state, effect, realName  FROM Cannon, SubPlace where SubPlace.name = Cannon.subPlaceName;') as $row){
          echo "<tr>";
          echo "<td>".$row['cannonID']."</td>";
          echo "<td>".$row['model']."</td>";
          echo "<td>".$row['realName']."</td>";
          echo "<td>".$row['state']."</td>";
          echo "<td>".$row['effect']."</td>";
          echo '';
          echo '<th><input type="checkbox" name="'.$selected[].'" value="'.$row["cannonID"].'"></th>';
          echo "</tr>";

          <input type="submit" value="Save" name="btn_save"> 


        }
        ?>
      </tr>
    </table>
  </div>

  <div class="w3-third w3-left">
     <h5>asd</h5>
    <select id="selecten"> 
      <option value="as">select status</option>
      <option name="status" value="on">on</option>
      <option name="status" value="off">off</option>
      <option name="status" value="unplugged">unplugged</option>
      <option name="status" value="broken">broken</option>     
    </select>
  </div>
</div>
</div>



<?php
   if(isset($_POST['btn_save'])) 
   {   $fruitArray = array('orange', 'apple', 'grapefruit', 'banana', 'watermelon'); 
       If(isset($_POST['fruit'])) 
       {   $values = array(); // store the selection 
           foreach($_POST['fruit'] as $selection )
           {   if(in_array($selection, $fruitArray)) 
               { $values[ $selection ] = 1; } 
               else 
               { $values[ $selection ] = 0; } 
           }
        }
    }
?>

<!-- 

<div class="w3-container w3-third w3-margin w3-section w3-right">


-->