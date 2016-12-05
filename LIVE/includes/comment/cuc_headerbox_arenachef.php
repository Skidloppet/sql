 <?php    

 foreach($pdo->query( 'select count(*)as a from OldCommenta;') as $row){
  $a = $row['a'];
}
foreach($pdo->query( 'select count(*)as b from OldCommenta where del="1"') as $row){
  $b = $row['b'];
}
?>

<div class="w3-row-padding w3-margin-bottom " style="cursor: pointer; cursor: hand;">  


  <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id33').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-orange w3-text-white w3-padding-16">
      <div class="w3-left"><i class="fa fa-flag alt w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3><?php print_r($a); ?></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Gamla kommentarer</h4>
    </div>
  </div>

  <div class="w3-quarter" style="cursor:pointer" onclick="document.getElementById('id69').style.display='block'">
    <div class="w3-panel w3-card-8 w3-text-shadow w3-round-xlarge w3-container w3-orange w3-text-white w3-padding-16">
      <div class="w3-left"><i class="fa fa-ban alt w3-xxxlarge"></i></div>
      <div class="w3-right">
        <h3><?php print_r($b); ?></h3>
      </div>
      <div class="w3-clear"></div>
      <h4>Borttagna kommentarer</h4>
    </div>
  </div>

</div>




<!-- The Modal -->
<div id="id33" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container w3-padding w3-margin w3-border-top">
      <span onclick="document.getElementById('id33').style.display='none'"
      class="w3-closebtn">&times;</span>
      <div class="w3-threethird">

      <div class="w3-left w3-content">

       <form id="radKom">
        <input type="checkbox" name="delete" value="1"> Radera alla lagrade kommentarer<br>
        <button type="button" onclick="SendForm('comments','comments','radKom');" class="HoverButton" >Skicka</button>
      </form></br>

      <?php 
      if(isset($_POST['delete'])){
        $querystring="delete from delLagKom where commentID>'0'";
        $stmt = $pdo->prepare($querystring);
        $stmt->bindParam(':editSkiID', $_POST['skiID1']);
          # select's name �r skiID
        $stmt->bindParam(':newType', $_POST['type']);
          # select's name �r type
        $stmt->execute();

  #uppdaterar sidan och visar nya l�nen
        //  header("Location: hemsida5.php");
      }
      ?>
</div>
      <div class="w3-left w3-content w3-border">
     <h5>Gamla kommentarer</h5>
     <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <tr>
        <th>Kommentar</th>
        <th>Alias</th>
        <th>Påverkade sträckor</th>
        <th>Betyg</th>
        <th>Datum skickad</th>
      </tr>        
      <?php     

      foreach($pdo->query( 'SELECT * FROM OldCommenta order by commentID desc;' ) as $row){
        $luck = $row['commentID'];
        echo "<tr>";
        echo "<td>".$row['kommentar']."</td>";
        echo "<td>".$row['alias']."</td>";
        echo "<td>";
        foreach($pdo->query( 'select realName from SubPlace, OldCommentSubPlace where SubPlace.name = OldCommentSubPlace.name and OldCommentSubPlace.commentID = '.$luck.';' ) as $brow){;
          echo $brow['realName']."</br>";
        };
        echo "</td>";
        echo "<td>".$row['grade']."</td>";
        echo "<td>".$row['date']."</td>";
        echo "</tr>";  
      }
      ?>   
    </table>
  </div>
</div>
</div>
</div>
</div>




<!-- The Modal -->
<div id="id69" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container w3-padding w3-margin w3-border-top">
      <span onclick="document.getElementById('id69').style.display='none'"
      class="w3-closebtn">&times;</span>
      <div class="w3-threethird">


      <div class="w3-left w3-content">

       <form id="radDel">
        <input type="checkbox" name="delete2" value="1"> Radera alla lagrade kommentarer<br>
        <button type="button" onclick="SendForm('comments','comments','radDel');" class="HoverButton" >Skicka</button>
      </form></br>

      <?php 
      if(isset($_POST['delete2'])){
        $querystring="delete from delDelKom where commentID>'0'";
        $stmt = $pdo->prepare($querystring);

        $stmt->execute();

  #uppdaterar sidan och visar nya l�nen
        //  header("Location: hemsida5.php");
      }
      ?>
</div>


        <h5>Borttagna kommentarer</h5>
        <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
          <tr>
            <th>Kommentar</th>
            <th>Alias</th>
            <th>Påverkade sträckor</th>
            <th>Betyg</th>
            <th>Datum skickad</th>
          </tr>        
          <?php     

          foreach($pdo->query( 'SELECT * FROM OldCommenta where del ="1" order by commentID desc;' ) as $row){
            echo "<tr>";
            echo "<td>".$row['kommentar']."</td>";
            echo "<td>".$row['alias']."</td>";
            echo "<td>";
            foreach($pdo->query( 'select realName from SubPlace, CommentSubPlace where SubPlace.name = CommentSubPlace.name and CommentSubPlace.commentID = '.$luck.';' ) as $brow){;
              echo $brow['realName']."</br>";
            };
            echo "</td>";
            echo "<td>".$row['grade']."</td>";
            echo "<td>".$row['date']."</td>";
            echo "</tr>";  
          }
          ?>   
        </table>
      </div>
    </div>
  </div>
</div>



