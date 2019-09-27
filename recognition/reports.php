<!DOCTYPE html>
<html>
<head>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

* {
  box-sizing: border-box;
}

#search {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
  box-shadow:2px 2px 10px 10px #708090;
  background-color: white;

}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}
</style>
</head>
<body style="background-color: #D9D5D5;">
<nav>
<div class="nav-wrapper" style="background-color: #4C4040">
          <a href="#!" class="brand-logo">Logo</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="index.php" style="text-decoration: none;" class="waves-effect waves-light btn-large">Snap</a></li>
      </ul>
  <form>
    <div class="input-field">
      <input id="search" type="search" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" autocomplete="off">

      <i class="material-icons">close</i>
    </div>
  </form>
</div>
</nav>


<div style="padding-right: 50px; padding-left: 50px; padding-top: 5px;">
<div style="margin-top: 40px; text-align: center;">
    <h2>Full Reports</h2>
</div>
<div>
    <div style="float: left; margin: 4px;">
        <p><button onclick="sortTable()"style="box-shadow:2px 2px 2px 2px #708090;
">Sort</button></p>
    </div>
    <div style="float:left; margin: 4px;">
        <p style="float:le"><button onClick="window.location.reload()" style="box-shadow:2px 2px 2px 2px #708090;
">UnSort</button></p>
    </div>
</div>
<div style="margin-top:50px;">
<table id="myTable" >
  <tr class="header">
    <th style="width:10%;">Id</th>
    <th style="width:30%;">First Name</th>
    <th style="width:30%;">Second Name</th>
    <th style="width:30%;">Date Time</th>


  </tr>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test";


        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
        } 
        $dailyReports = "select * from tracking";
        $result1 = mysqli_query($conn, $dailyReports);
        $i = 1;
        while($row = mysqli_fetch_assoc($result1)) {
        echo "<tr>";
            echo "<td>" . $i ."</td>";
            echo "<td>" . $row['username'] ."</td>";
            echo "<td>" . $row['secondname'] ."</td>";
            echo "<td>" . $row['time'] ."</td>";
            $i++;
        echo "</tr>";
        

        }
    ?>
</table>
</div>
</div>
<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";

      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("myTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[1];
      y = rows[i + 1].getElementsByTagName("TD")[1];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>

</body>
</html>
