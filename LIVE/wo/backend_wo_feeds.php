<h5>Översikt</h5>
         <?php
		include './connect.php';		
		?>	
			
<div class="w3-container w3-section">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-threethird">
        <h5>Pågående arbetsordrar</h5>
        <table class="w3-table w3-striped w3-white">
          <tr>
            <td><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></td>
            <td>OrderID</td>
            <td>skiID</td>
			<td>entID</td>
            <td>SentDate</td>
			<td>priority</td>
          </tr>        
<?php			
	
		foreach($pdo->query( 'SELECT * FROM WorkOrder;' ) as $row){
      echo "<tr>";
	  echo "<td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
	  echo "<td><a href='finnishedWorkOrder.php?orderID=".urlencode($row['orderID'])."'>".$row['orderID']."</td>";
	  echo "<td>".$row['skiID']."</td>";
	  echo "<td>".$row['entID']."</td>";
	  echo "<td>".$row['sentDate']."</td>";
	  echo "<td>".$row['priority']."</td>";
	  echo "</tr>";  
    }
	?>	 
        </table>
      </div>

      <div class="w3-threethird">
        <h5>avslutade arbetsordrar</h5>
        <table class="w3-table w3-striped w3-white">
          <tr>
            <td><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></td>
            <td>OrderID</td>
            <td>skiID</td>
      <td>entID</td>
            <td>SentDate</td>
      <td>priority</td>
          </tr>        
<?php     
  
    foreach($pdo->query( 'SELECT * FROM FinnishedWorkOrder;' ) as $row){
      echo "<tr>";
    echo "<td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
    echo "<td><a href='finnishedWorkOrder.php?orderID=".urlencode($row['orderID'])."'>".$row['orderID']."</td>";
    echo "<td>".$row['skiID']."</td>";
    echo "<td>".$row['entID']."</td>";
    echo "<td>".$row['sentDate']."</td>";
    echo "<td>".$row['priority']."</td>";
    echo "</tr>";  
    }
  ?>   
        </table>
      </div>

    </div>
  </div>