<h2>Översikt</h2>

<?php
include './connect.php';	
?>	
<div class="w3-container w3-section">
  <div class="w3-row-padding" style="margin:0 -16px">
   <div class="w3-threethird">
    <h4>akuta arbetsordrar</h4>
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

      foreach($pdo->query( 'SELECT * FROM WorkOrder where priority="akut" and entID="1";' ) as $row){
        echo "<tr>";
        echo "<td><i class='fa fa-eye w3-blue w3-padding-tiny'></i></td>";
        echo "<td><a href='backend_wo.php?akutOrderID=".urlencode($row['orderID'])."'>".$row['orderID']."</td>";
        echo "<td>".$row['skiID']."</td>";
        echo "<td>".$row['entID']."</td>";
        echo "<td>".$row['sentDate']."</td>";
        echo "<td>".$row['priority']."</td>";
        echo "</tr>";  
      }
      ?>   
    </table>
  </div>


  


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
        <h4>avslutade arbetsordrar</h4>
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




      <div class="w3-threethird">
        <h4>mottagna akuta arbetsordrar(entID!= 1)</h4>
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

          foreach($pdo->query( 'SELECT * FROM WorkOrder where priority="akut" and entID!="1";' ) as $row){
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


<!-- DIV ID NUMMER 2 -->
        <h2 id="2">mina arbetsordrarr ( logged in as: .<?php echo $em?> )</h2>

      <div class="w3-threethird">
        <h4>mina arbetsordrarr ( logged in as: .<?php echo $em?> )</h4>
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

          foreach($pdo->query( "SELECT skiID, WorkOrder.entID, sentDate, priority, orderID FROM WorkOrder, Ent where Ent.email = '$em' and Ent.entID = WorkOrder.entID") as $row){
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
        <h5>mina avslutade arbetsordrarr ( logged in as: .<?php echo $em?> )</h5>
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

          foreach($pdo->query( "SELECT skiID, FinnishedWorkOrder.entID, sentDate, priority, orderID FROM FinnishedWorkOrder, Ent where Ent.email = '$em' and Ent.entID = FinnishedWorkOrder.entID") as $row){
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