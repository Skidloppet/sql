<!DOCTYPE html>

<?php
include'../connect.php';
?>


<div id="12" class="w3-container w3-blue">
    <h3>Utskrift av rapporter per sträcka:</h3>
    <table class="w3-table w3-striped w3-white">
      <?php   
        echo "<tr>";
          echo "<th>sträcka:</th>"; 
          #echo "<th>realName</th>"; 
          //echo "<th>newEntID</th>"; 
          echo "<th>Entreprenör:</th>"; 
          echo "<th>Rapporterad:</th>"; 
          echo "<th>Nästa arbetspass:</th>"; 
          echo "<th>Betyg:</th>"; 
          echo "<th>Underlag:</th>"; 
          echo "<th>Spårkanter:</th>"; 
          echo "<th>Stavfäste:</th>"; 
          echo "<th>Snödjup:</th>";
          echo "<th>Kommentar:</th>"; 
          echo "<th>report ID:</th>"; 
          echo "<th>heheheh ID:</th>"; 
          echo "</tr>";

            foreach ($pdo->query('
                SELECT Reporting.name, Reporting.entID, Reporting.startDate, Reporting.workDate, Reporting.rating, Reporting.underlay, Reporting.edges, Reporting.grip, Reporting.depth, Reporting.comment, SubPlace.realName, Ent.firstName, Ent.lastName, Reporting.reportID
				        from overview, Reporting, SubPlace, Ent
				        WHERE Reporting.name = rspName AND Reporting.reportID = rspID AND Ent.entID = Reporting.entID AND SubPlace.name = Reporting.name
				        GROUP BY Reporting.name;
              ')as $row) {
                
          echo "<tr>";
          #echo "<td>".$row['name']."</td>";
          echo "<td>".$row['realName']."</td>";
          //echo "<td>".$row['entID']."</td>";
          echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
          echo "<td>".$row['startDate']."</td>";
          echo "<td>".$row['workDate']."</td>";
          echo "<td>".$row['rating']."</td>";
          echo "<td>".$row['underlay']."</td>";
          echo "<td>".$row['edges']."</td>";
          echo "<td>".$row['grip']."</td>";
          echo "<td>".$row['depth']."</td>";
          echo "<td>".$row['comment']."</td>";
          echo "<td>".$row['reportID']."</td>";
          ?>
          <td class="Report-delete">
            <form action='<?php $_PHP_SELF ?>' method='POST'>
              <input type="hidden" name="deleteReport" value="<?php echo $row['reportID']; ?>">
              <input class="HoverButton" type="submit" name="delReport" value="Delete">
            </form>
          </td>
<!--
          <td class="Report-Store">
            <form action='backend_report.php?reportID="<?php# echo $Report['reportID']; ?>"' <!--<!--method='POST'>
              <input type="hidden" name="storeReport" value="<?php# $row['reportID']; ?>">
              <!--<input class="HoverButton2" type="submit" name="storeReport" value="Store">
            </form>
          </td>
-->
        <?php
          #echo "</tr>";  
          }
      ?>
    </table><br><br>
</div>
<?php
  if(isset($_POST['delReport'])){
  $deletedReport = $_POST['deleteReport'];
  $sql = "DELETE FROM Report WHERE reportID = $deletedReport" ;
  $sql = "DELETE FROM ReportSubPlace WHERE reportID = $deletedReport" ;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
    }
?>
<?php
/*
if(isset($_POST['storeReport'])){
  $querystring='INSERT INTO StoredReports (reportID, entID, startDate, workDate, rating, underlay, edges, grip, depth, comment, name) VALUES (:reportID, :entID, :startDate, :workDate, :rating, :underlay, :edges, :grip, :depth, :comment, :name);';
    $stmt = $pdo->prepare($querystring);
    $stmt->bindParam(":reportID", $row['reportID'], PDO::PARAM_INT);
    $stmt->bindParam(":entID", $row['entID'], PDO::PARAM_INT);
    $stmt->bindParam(":startDate", $row['startDate'], PDO::PARAM_STR);
    $stmt->bindParam(":workDate", $row['workDate'], PDO::PARAM_STR);
    $stmt->bindParam(":rating", $row['rating'], PDO::PARAM_INT);
    $stmt->bindParam(":underlay", $row['underlay'], PDO::PARAM_INT);
    $stmt->bindParam(":edges", $row['edges'], PDO::PARAM_INT);
    $stmt->bindParam(":grip", $row['grip'], PDO::PARAM_INT);
    $stmt->bindParam(":depth", $row['depth'], PDO::PARAM_INT);
    $stmt->bindParam(":comment", $row['comment'], PDO::PARAM_STR);
    $stmt->bindParam(":name", $row['name'], PDO::PARAM_INT);
    $stmt->execute();
    }

?>
<div id="13" class="w3-container w3-green">
    <h3>Utskrift av sparade rapporter</h3>
    <table class="w3-table w3-striped w3-white">
      <?php   
      /*
        echo "<tr>";
          echo "<th>reportID</th>"; 
          echo "<th>newEntID</th>"; 
          echo "<th>newStartDate</th>"; 
          echo "<th>newWorkDate</th>"; 
          echo "<th>newRating</th>"; 
          echo "<th>newUnderlay</th>"; 
          echo "<th>newEdges</th>"; 
          echo "<th>newGrip</th>"; 
          echo "<th>newDepth</th>";
          echo "<th>kommentar</th>";
          echo "<th>sträcka</th>";  
          echo "</tr>";
        foreach($pdo->query( 'SELECT * FROM StoredReports;' ) as $row){
          //echo "<tr><td>";
          //echo "<a href='test.php?entID=".urlencode($row['entID'])."'>".$row['entID'];
          echo "<tr>";
          echo "<td>".$row['reportID']."</td>";
          echo "<td>".$row['entID']."</td>";
          echo "<td>".$row['startDate']."</td>";
          echo "<td>".$row['workDate']."</td>";
          echo "<td>".$row['rating']."</td>";
          echo "<td>".$row['underlay']."</td>";
          echo "<td>".$row['edges']."</td>";
          echo "<td>".$row['grip']."</td>";
          echo "<td>".$row['depth']."</td>";
          echo "<td>".$row['comment']."</td>";
          echo "<td>".$row['name']."</td>";
}
*/
?>
<!--</table>
<br><br>
-->

<!-- End page content -->
</div>

<div id="11" class="w3-container w3-red">
  <h3>Ny Rapport</h3>
  <form action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method='POST' id="_newReport">
    <input type="text" name="WorkDate" placeholder="yyyy-mm-dd"></p>
    <input type="text" name="Depth" placeholder="Djup.."></p>

    <p>Helhetsbetyg:</p>
    <select name="Rating">
      <?php
      $sql = 'SHOW COLUMNS FROM Report WHERE field="rating"';
      $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
            print("<option>$option</option>");
       }
      ?>
    </select>

    <p>Underlag:</p>
    <select name="Underlay">
      <?php
      $sql = 'SHOW COLUMNS FROM Report WHERE field="underlay"';
      $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
            print("<option>$option</option>");
       }
      ?>
    </select>
  
    <p>Spårkanter:</p>
    <select name="Edges">
      <?php
      $sql = 'SHOW COLUMNS FROM Report WHERE field="edges"';
      $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
            print("<option>$option</option>");
       }
      ?>
    </select>

    <p>Stavfäste:</p>
    <select name="Grip">
      <?php
      $sql = 'SHOW COLUMNS FROM Report WHERE field="grip"';
      $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
            print("<option>$option</option>");
       }
      ?>
    </select>

    <p>Start</p>
    <select name='Start'>    
      <?php 
      foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
        echo '<option value="'.$row['name'].'">';
        echo $row['realName'];
        echo "</option>";
      }
      ?></select>
      <p>Slut</p>
    <select name='Slut'>    
      <?php 
      foreach ($pdo->query('SELECT * FROM SubPlace') as $row) {
        echo '<option value="'.$row['name'].'">';
        echo $row['realName'];
        echo "</option>";
      }
      ?></select><br><br>

    <textarea rows="5" cols="70" name="comment" placeholder="Kommentar..."></textarea>


    <p><button type="submit" name="_newReport">Ny rapport</button></p></form>

  <?php

  if(isset($_POST['_newReport'])){

    $sql = "CALL _newReport(:newEntID, now(), :newWorkDate, :newRating, :newUnderlay, :newEdges, :newGrip, :newDepth, :newComment, :startName, :endName)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":newEntID", $_SESSION['id'], PDO::PARAM_INT);
    //$stmt->bindParam(":newStartDate", $_POST['StartDate'], PDO::PARAM_STR);
    $stmt->bindParam(":newWorkDate", $_POST['WorkDate'], PDO::PARAM_STR);
    $stmt->bindParam(":newRating", $_POST['Rating'], PDO::PARAM_INT);
    $stmt->bindParam(":newUnderlay", $_POST['Underlay'], PDO::PARAM_INT);
    $stmt->bindParam(":newEdges", $_POST['Edges'], PDO::PARAM_INT);
    $stmt->bindParam(":newGrip", $_POST['Grip'], PDO::PARAM_INT);
    $stmt->bindParam(":newDepth", $_POST['Depth'], PDO::PARAM_INT);
    $stmt->bindParam(":newComment", $_POST['comment'], PDO::PARAM_STR);
    $stmt->bindParam(":startName", $_POST['Start'], PDO::PARAM_INT);
    $stmt->bindParam(":endName", $_POST['Slut'], PDO::PARAM_INT);
    $stmt->execute();
}
      
?>
</div>
</div>
</div>




<script type="text/javascript">
/*
$(document).ready(function() {  
$('#_newReport').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: 'rep_feeds_arenachef.php',
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#11').fadeOut('slow', function(){
          $('#11').fadeIn('slow').html(data);
        });
    })
    .fail(function(){
 alert('Ajax Submit Failed ...'); 
    });
});


/*
$('#_newReport').submit(function(){

      // gather the form data
      var data=$(this).serialize();
      // post data
      $.post('rep_feeds_arenachef.php', data , function(returnData){
                  // insert returned html 
                  $('#12').html( returnData)

                  post('Funkar?');
      })

      return false; // stops browser from doing default submit process
      post('Funkar inte');
});

$("_newReport").submit(function(e) {
    e.preventDefault();
    $.ajax({
    type: "POST",
    url: "./rep_feeds_arenachef.php",
    data: dataString,
    success: function(){
        $("#12").load("rep_feeds_arenachef.php"); 
    }
    });
return false;
});
     /* $(function () {

        $('#_newReport').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: 'rep_feeds_arenachef.php',
            data: $('#_newReport').serialize(),
            success: function () {
              alert('form was submitted');
            }
          });

        });

      });
      */
      </script>
      <script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
  if (mySidenav.style.display === 'block') {
    mySidenav.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidenav.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidenav with the close button
function w3_close() {
  mySidenav.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>