<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facial Recogition</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>    
     <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script>  
    $(document).ready(function() {
      $("#formButton").click(function() {
        $("#register").toggle("slow");

      });
    });  
    </script> 

    <script>  
        $(document).ready(function() {
          $("#query").click(function() {
            $("#get").slideToggle("slow");
        
        
          });
        });  
        </script> 
    <style type="text/css">

* {
  box-sizing: border-box;
}
#myInput {
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
body{
    background-color: #D9D5D5;
}

/* Add padding to containers */
.container {
  padding: 10px;
  background-color: white;
  border-radius: 8px;
 box-shadow:2px 2px 10px 10px #888888;
}


/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 5px;
  margin: 2px 0 5px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 20px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
.container{
    margin-top: 70px;
}
        @-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
        @-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
        @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

        .fade-in {
            opacity:0;  /* make things invisible upon start */
            -webkit-animation:fadeIn ease-in 1;  /* call our keyframe named fadeIn, use animattion ease-in and repeat it only 1 time */
            -moz-animation:fadeIn ease-in 1;
            animation:fadeIn ease-in 1;

            -webkit-animation-fill-mode:forwards;  /* this makes sure that after animation is done we remain at the last keyframe value (opacity: 1)*/
            -moz-animation-fill-mode:forwards;
            animation-fill-mode:forwards;

            -webkit-animation-duration:1s;
            -moz-animation-duration:1s;
            animation-duration:1s;
        }

        .fade-in.one {
        -webkit-animation-delay: 0.7s;
        -moz-animation-delay: 0.7s;
        animation-delay: 0.7s;
        }

        /*---make a basic box ---*/
       
        }
</style>

</head>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";


    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
    } 
    $sql = "SELECT username, secondname from users";
    $result = mysqli_query($conn, $sql);

?>
<body>

<nav>
<div class="nav-wrapper" style="background-color: #4C4040">
    <a href="#!" class="brand-logo">Logo</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="reports.php"   style="text-decoration: none;"
 class="waves-effect waves-light btn-large">Reports</a></li>
      </ul>
  <form>
    <div class="input-field">
      <input id="search" type="search" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" autocomplete="off">

      <i class="material-icons">close</i>
    </div>
  </form>
</div>
</nav>
<div class="box fade-in one" >
<div class="container ">
    <h1 class="text-center" style="font-family: Courier; font-weight: bold;">RECOGNITION SYSTEM</h1>
    <hr style="border-color:#a2a2a2;">
    <br>
    <form method="POST" action="storeImage.php" id="myForm">
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <br/>
                <input class="btn btn-success" type=button value="Snap" onClick="take_snapshot()" style="float:left">
                <input list="people" name="people" autocomplete="off" placeholder="Select your name from here"> 
                <datalist id="people"> 
                    <?php
                        while($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="'.$row['username'].' '. $row['secondname'].'">';

                    }
                    ?> 
                </datalist>

                <input type="hidden" name="image" class="image-tag" required>
            </div>
            <div class="col-md-6">
                <div id="results" style="display: block; height: 25px; text-align:center; line-height:25px;">Your captured image will appear here...</div>
            </div>

        </div>
        <table style="width: 100%;" >
            <tr style="border-color:#a2a2a2; border-width: 3px;">
                <th>
                    <button class="btn btn-success" type="button" id="formButton">Registration</button>
                </th>
                <th>

                    <button  class="btn btn-success" type="button" id="query" onclick="document.getElementById('get').innerHTML = report()"><?php echo date("Y-m-d")?></button>
                </th>
                <th>
                <button class="btn btn-success class="col-md-12 text-center value="ignore" formnovalidate>Log In </button>
                </th>
            </tr>
        </table>
                <div id="register" style="display:none;" align="right">
                    <label for="fname"><b>First Name</b></label>
                    <input type="text" placeholder="Enter First Name" autocomplete="off" name="fname" required>

                    <label for="lname"><b>Last Name</b></label>
                    <input type="text" placeholder="Enter Last Name" autocomplete="off" name="lname" required>

                    <button type="submit" class="registerbtn" align="right">Register</button>
                </div>
                <div id='get' style="display:none;">

                    <table id="myTable">
                        <thead>
                            <tr class="header">
                                <th>Id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Time In</th>
                                <th><button onclick="window.location.href = 'reports.php';">Full Reports</button></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $dailyReports = "select id, username, secondname, TIME(time)  from tracking where DATE(time) =  CURDATE()";
                            $result1 = mysqli_query($conn, $dailyReports);
                            $i = 1;
                            while($row = mysqli_fetch_assoc($result1)) {
                            echo "<tr>";
                                echo "<td>" . $i ."</td>";
                                echo "<td>" . $row['username'] ."</td>";
                                echo "<td>" . $row['secondname'] ."</td>";
                                echo "<td>" . $row['TIME(time)'] ."</td>";
                                $i++;
                            echo "</tr>";
                            

                            }
                        ?>
                    </tbody>
                </table>
                <script>
                function myFunction() {
                  var input, filter, table, tr, td, i, txtValue;
                  input = document.getElementById("myInput");
                  filter = input.value.toUpperCase();
                  table = document.getElementById("myTable");
                  tr = table.getElementsByTagName("tr");
                  for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
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
                </script>
                </div>                  

        

    </form>
</div>

</div>
<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    Webcam.set({
        width: 500,
        height: 400,
        image_format: 'jpg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            document.getElementById('hi').submit();

        } );

    }

</script>

 
</body>
</html>