
<?php
include '../connect.php';	
?>
<div class="w3-container ">
  <div class="w3-container w3-section">
    <div class="w3-row-padding" style="margin:0 -16px">



      <?php
      $akut = 0;
      foreach($pdo->query( 'SELECT count(*) as nmr FROM wo where priority="akut" and entID="1";' ) as $row){
        $akut = $row['nmr'];
        if (0 < $akut){
          ?>
<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:red; border-style: solid; border-width: 5px;">
            <div class="w3-container w3-section">
              <div class="w3-row-padding" style="margin:0 -16px">
                <div class="w3-threethird">
                  <h1>Akuta arbetsordrar</h1>
					<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                    <tr>
                      <th><u>Datum skickad</u></th>
                      <th>Arbetsorder-Typ</th>
                      <th>Område(n)</th>
                      <th>Prioritet</th>
                      <th>Information</th>
                      <th>Skapad av</th>
                    </tr> 

                    <?php     
        # hämtar alla aktiva arbetsordrar(WorkOrder) som tillhör det autoangivna akutID (#1)
        # hemsidan visar entrepenörens förnamn och enfternamn genom kopplingen mellan

                    foreach($pdo->query( 'SELECT * FROM wo where priority="akut" and entID="1" order by sentDate desc;' ) as $row){
                     echo "<td>".$row['sentDate']."</td>";
                     echo "<td>".$row['type']."</td>";
                     echo "<td>";
                     if ($row['type'] === "kanon" ){
                      foreach($pdo->query( 'select realName from SubPlace,CannonSubPlace where SubPlace.name = CannonSubPlace.name and orderID = '.$row ['orderID'].';' ) as $brow){
                        echo $brow['realName']."</br>";
                      }} else {
                        foreach($pdo->query( 'select realName from SubPlace, SubPlaceWorkOrder where SubPlace.name = SubPlaceWorkOrder.name and SubPlaceWorkOrder.orderID = '.$row ['orderID'].';' ) as $brow){;
                          echo $brow['realName']."</br>";
                        }}
                        echo "</td>";
                        echo "<td>".$row['priority']."</td>";
                        echo "<td>".$row['info']."</td>";
                        echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
                        ?>

                        <?php
                        echo "</td></tr>";  
                      }
                      ?>   
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <?php
          }
        }
        ?>

      </div>
    </div>


<div class="w3-row-padding w3-panel w3-card-8 w3-round-xlarge" style=" border-color:lightblue; border-style: solid; border-width: 5px;">
      <div class="w3-threethird">
        <h1>Pågående arbetsordrar</h1>
		<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
          <tr>
            <th><u>Datum skickad</u></th>
            <th>Område(n)</th>
            <th>Arbetsorder-Typ</th>
            <th>Prioritet</th>
            <th>Ansvarig</th>
            <th>Information</th>
            <th>Skapad av</th>

          </tr>        
          <?php     

          foreach($pdo->query( 'SELECT * FROM wo order by sentDate desc;' ) as $row){
                echo "<td>".$row['sentDate']."</td>";
            echo "<td>";
            if ($row['type'] === "kanon" ){
              foreach($pdo->query( 'select realName from SubPlace,CannonSubPlace where SubPlace.name = CannonSubPlace.name and orderID = '.$row ['orderID'].';' ) as $brow){
                echo $brow['realName']."</br>";
              }} else {
                foreach($pdo->query( 'select realName from SubPlace, SubPlaceWorkOrder where SubPlace.name = SubPlaceWorkOrder.name and SubPlaceWorkOrder.orderID = '.$row ['orderID'].';' ) as $brow){;
                  echo $brow['realName']."</br>";
                }}
                echo "</td>";
                echo "<td>".$row['type']."</td>";
                echo "<td>".$row['priority']."</td>";
                echo "<td>".$row['entF']." ".$row['entL']."</td>";
                echo "<td>".$row['info']."</td>";
                echo "<td>".$row['skiF']." ".$row['skiL']."</td>";
                ?>

              </tr>

              <?php
            }
            ?>   
          </table>
        </div>
      </div>
    </div>
  </div>

<?php /*
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
  </div> */