<!DOCTYPE html>
<html>
<head>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title></title>
    <style>
         /* make keyframes that tell the start state and the end state of our object */

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
        .box{
        width: 200px;
        height: 200px;
        position: relative;
        margin: 10px;
        float: left;
        border: 1px solid #333;
        background: #999;
        }
    .tile--css_animations__demo2 div {
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 75%;
    width: 100%;
}
.tile--css_animations__demo2 div:nth-of-type(odd) {
    background: black;
}
.tile--css_animations__demo2 div:nth-of-type(even) {
    background: white;
    border: 2px solid black;
}
.tile--css_animations__demo2 div:nth-of-type(3) {
    height: 10px;
    width: 10px;
    margin-top: -5px;
    margin-left: -5px;
    -webkit-animation: slide 3s ease-in-out infinite;
    animation: slide 3s ease-in-out infinite;
}
.tile--css_animations__demo2 div:nth-of-type(2) {
    height: 20px;
    width: 20px;
    margin-top: -12px;
    margin-left: -12px;
    -webkit-animation: slide 3s -2.7s ease-in-out infinite;
    animation: slide 3s -2.7s ease-in-out infinite;
}
.tile--css_animations__demo2 div:nth-of-type(1) {
    height: 40px;
    width: 40px;
    margin-top: -20px;
    margin-left: -20px;
    -webkit-animation: slide 3s -2.4s ease-in-out infinite;
    animation: slide 3s -2.4s ease-in-out infinite;
}
@keyframes slide {
    0% {
        left: 75%
    }
    50% {
        left: 25%;
    }
    100% {
        left: 75%;
    }
}
@-webkit-keyframes slide {
    0% {
        left: 75%
    }
    50% {
        left: 25%;
    }
    100% {
        left: 75%;
    }
}
</style>
</head>

<?php
    require 'vendor/autoload.php';
    use Aws\Rekognition\RekognitionClient;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";
    $info = "";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
    } #echo "Connected to database";


    function compare($faces, $face){
        //Credentials for access AWS Service code parameter
        $credentials = new Aws\Credentials\Credentials('AKIA5OHHPUTSLJU4S6NG', '49KsbEqu/gfJhwRs6GZyBwWDmenpifQXPxzOP4u5');
        //Get Rekognition Access
        $client = RekognitionClient::factory(array(
                    'region'    => "us-east-1",
                    'version'   => 'latest',
                'credentials' => $credentials
        ));

        //Calling Compare Face function
        $result= $client->compareFaces([
                'SimilarityThreshold' => 95,
                'SourceImage' => [
                    'Bytes' => file_get_contents("$faces")
                ],
                'TargetImage' => [
                    'Bytes' => file_get_contents("$face")
                ],
        ]);
        if(!empty($result['FaceMatches'])){
            if ($result['FaceMatches'][0]["Similarity"] > 90){
                return "Verified";

            } else {
                return "Unverified";
            }
        } else{
            return "DintMatch";
        }
    }
    $today = date("Y-m-d");
    $img = $_POST['image'];
    
    $image_parts = explode(";base64,", $img);


    $image_type_aux = explode("image/", $image_parts[0]);

    $image_type = $image_type_aux[1];
    
    $image_base64 = base64_decode($image_parts[1]);
  
    
    if(strlen($_POST['fname']) > 2){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $fileName = $fname . " " . $lname . " " . date("h:i:s") . '.jpg';



        $userspath = 'upload/registeredusers';
        if (!file_exists($userspath)){
            mkdir($userspath, 0777, true);
        }
        $userimg = $userspath ."/". $fileName;
        $sql = "INSERT INTO users (username, secondname, dbpath) VALUES ('$fname' , '$lname', '$userimg')";
        if (mysqli_query($conn, $sql)) {
            $info = "User $fname $lname registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
        file_put_contents($userimg, $image_base64);
    } else{
        $person = $_POST['people'];
        $folderPath = "upload/$today";
        if (!file_exists($folderPath)){
            mkdir($folderPath, 0777, true);
            #echo("folder created successfully");
        }
        $fname = explode(' ', $person)[0];
        $lname = explode(' ', $person)[1];
        $fileName = $fname . " " . $lname . " " . date("h:i:s") . '.jpg';
        $file = $folderPath ."/". $fileName;
        file_put_contents($file, $image_base64);
        $sql1 = "SELECT username, secondname, dbpath from users where username like '%$fname%' and secondname like '%$lname%'";
        $result1 = mysqli_query($conn, $sql1);

        if (mysqli_num_rows($result1) > 0) {
            while($row = mysqli_fetch_assoc($result1)) {
                #echo "Welcome" . $row['username'] . " " . $row['secondname'];
                $photo = explode("/", $row["dbpath"])[2];
                $photo = getcwd()."/upload/registeredusers" . "/" .$photo;
                $compareResults = compare($photo, $file);

                if ($compareResults == "Verified"){
                     $logdin = "INSERT INTO tracking (username, secondname) VALUES ('$fname' , '$lname')";
                    if (mysqli_query($conn, $logdin)) {
                        $info = "Welcome " . $row['username'] . " " . $row['secondname'];
                    } else {
                        $info = "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    mysqli_close($conn);
                } elseif ($compareResults == "Unverified") {
                     $info = "Try with a better posture";
                }elseif ($compareResults == "DintMatch") {
                     $info = "Access Denied(?): <br>1. Wrong match<br>2. Not Registered";
                } else{
                     $info = "Access Denied(?): <br>1. Wrong match<br>2. Not Registered";
                }

            }
        }
    }

echo "<script type='text/javascript'> window.setTimeout(function(){ window.location.href = 'index.php'; }, 5000);</script>";



    #alert("Photo Successfully Saved");

    #function alert($msg) {
     #   echo "<script type='text/javascript'>alert('$msg');</script>";
        #echo "<script type='text/javascript'> window.location.href = 'index.php';</script>";

    #}
  
?>
<div class="tile--css_animations__demo2">
    <div></div>
    <div></div>
    <div></div>
</div>
  <div class="row box fade-in one"style="width:500px;
    height: 500px;
    background-color: #32CD32;
    
    position: absolute;
    top:0;
    bottom: 0;
    left: 0;
    right: 0;
     border-radius:8px;
    margin: auto;">
  <i class="large material-icons"style="align-items: center;">person</i>
            <?php
               echo "<p style='font-size: 50px; text-align: center; font-weight: bold'>$info</p>"
          ?>

  </div>


<body>

</body>
</html>