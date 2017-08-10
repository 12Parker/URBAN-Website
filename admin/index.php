<!DOCTYPE html>
<html>
  <head>
    <link rel = "stylesheet" type = "text/css" href = "../stylesheets/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script async src = "../js/validate.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

    <script>
      //Function to disable a certain input if another input contains a value.
      function siteError($siteIDError) 
      {
      	var list = document.getElementById('errors');
      	if ($siteIDError == 'True') 
      	{
        	console.log("SiteID Not Valid");
        	error = "Site ID Already Exists";  
        }
        	var ulist = document.createElement('ul');
        	var err = document.createElement('li');
        	err.appendChild(document.createTextNode(error));
        	var add = ulist.appendChild(err);
        	list.appendChild(add);
      }
      //Displays a list of all valid URBAN sites
      function displaySiteList() 
      {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {
          if (this.readyState == 4 && this.status == 200) 
          {
            document.getElementById("info").innerHTML = this.responseText;
          } 
        };
        xmlhttp.open("GET","php/getSite.php",true);
        xmlhttp.send();
      }
      //Deletes a div from the screen. Mainly used for removing list of site ID's
      function removeDiv(parent, child) 
      {
        var parentNode = document.getElementById(parent);
        var childNode = document.getElementById(child);
        parentNode.removeChild(childNode);
      }
    </script>
  </head>
  <title>Urban Chlorophyll Data</title>
  <body>
    <?php
      require("../php/credentials.php");
      $link = mysqli_connect($host, $username, $password, $database);

  	 if (!$link)
  	 { //Print error message
      	echo "Error: Unable to connect to website." . PHP_EOL;
      	//echo "Debugging err number: " . mysqli_connect_errno() . PHP_EOL;
      	exit;
  	 }
    ?>
    <div id = "header">
      <h1>Admin Home</h1>
    </div>

    <div id = "errors">
    </div>

    <div id = "container">
      <form onsubmit = "return validate(false)" class="cf" action = "<?= $_SERVER['PHP_SELF'] ?>" method = "post" enctype = "multipart/form-data">
      <input type="hidden" name="destination" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"/>
        <!-- Left side of inputs-->
        <div class="half left cf">         
          <label for "siteID">Site ID</label>
          <input required name = "siteID" type="text" id="input-siteID" placeholder="Site ID*" value = "<?php echo isset($_POST['siteID']) ? $_POST['siteID'] : '' ?>">

          <label for "siteDescription">Description</label>
          <input required name = "siteDescription" type="text" id="input-siteDescription" placeholder="Site Description*" maxlength="100" value = "<?php echo isset($_POST['siteDescription']) ? $_POST['siteDescription'] : '' ?>">

          <label for "siteID">Stream Name</label>
          <input required name = "stream" type="text" id="input-stream" placeholder="Stream Name*" value = "<?php echo isset($_POST['stream']) ? $_POST['stream'] : '' ?>" >
        </div>

        <!-- Right side of inputs-->
        <div class="half right cf">
          <label for "lat">Latitude</label>
          <input  required default = "0" name="lat" type="number" min = "-180" max = "180" step = "0.0001" id="input-lat" placeholder="Latitude of Site*" value = "<?php echo isset($_POST['lat']) ? $_POST['lat'] : '' ?>">

          <label for "lng">Longitude</label>
          <input  required default = "0" name="lng" type="number" min = "-180" max = "180" step = "0.0001" id="input-lng" placeholder="Longitude of Site*" value = "<?php echo isset($_POST['lng']) ? $_POST['lng'] : '' ?>">

          <label for "siteID">Picture</label>
          <input name = "picture" type="file" id="input-picture" placeholder="Site Picture">

        </div>
          <!-- Make Report Card Span Entire Width Of Screen-->
          <label for "siteID">Report Card</label>
          <input name = "reportCard" type="file" id="input-reportCard">

        <div id = "info">
        </div> <br />
        <input name = "submit" type="submit" value="Submit" id="input-submit">
      </form>
    </div>

    <div id = "goToMap">
      <a href = "../map" class = "button">Go To Map</a>
    </div>

<?php
  //Upload to a database
  if ($_POST != null) 
  {
  require("../php/credentials.php");

  $link = mysqli_connect($host, $username, $password, $database);

  if (!$link) { //Print error message
    echo "Error: Unable to connect to website." . PHP_EOL;
    //echo "Debugging err number: " . mysqli_connect_errno() . PHP_EOL;
    exit;
  }
  $image_dir = "../images/";
  $report_dir = "../reportCards/";

  //Remove whitespace and make lower case
  $imageTmpName = strtolower(str_replace( ' ', '', $_POST['stream'])) . ".jpg";
  $reportTmpName = strtolower(str_replace( ' ', '', $_POST['stream'])) . ".pdf";

  //Add directory to file name for renaming later
  $imageName = $image_dir . strtolower(str_replace( ' ', '', $_POST['stream'])) . ".jpg";
  $reportName = $report_dir . strtolower(str_replace( ' ', '', $_POST['stream'])) . ".pdf";

  //Set path for image and report
  $image_file = $image_dir . basename($_FILES["picture"]["name"]);
  $report_file = $report_dir . basename($_FILES["reportCard"]["name"]);

  //Find out what the extension of each file is
  $imageFileType = pathinfo($image_file,PATHINFO_EXTENSION);
  $reportFileType = pathinfo($report_file,PATHINFO_EXTENSION);

  //Upload Variable
  $uploadOk = 1;

  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    //Check for real image
      $check = getimagesize($_FILES["picture"]["tmp_name"]);
      if($check !== false) {
          //echo "File is an image - " . $check["mime"] . ".\n";
          $uploadOk = 1;
      } else {
          //echo "File is not an image.";
          $uploadOk = 0;
      }

      //Check for real pdf
      $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
      $reportCheck =  finfo_file($finfo, $_FILES["reportCard"]["tmp_name"]);

    if ($reportCheck == "application/pdf") {
      $uploadOk = 1;
    } else {
      $uploadOk = 0;
      //echo "File is not a pdf.\n";
    }
    finfo_close($finfo);

  }
  // Check if file already exists
  if (file_exists($image_file)) {
      //echo "Sorry, image already exists.\n";
      $uploadOk = 0;
  }
  if (file_exists($report_file)) {
      //echo "Sorry, report already exists.\n";
      $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["picture"]["size"] > 8000000) {
     // echo "Sorry, image file is too large.\n";
      $uploadOk = 0;
  }
  if ($_FILES["reportCard"]["size"] > 8000000) {
      //echo "Sorry, report file is too large.\n";
      $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "jpeg") {
      //echo "Sorry, only JPG, JPEG files are allowed.\n";
      $uploadOk = 0;
  }

  //Variables - Sanitize inputs
  $siteID = filter_var($_POST['siteID'], FILTER_SANITIZE_STRING);
  $Description = filter_var($_POST['siteDescription'] , FILTER_SANITIZE_STRING);
  $Stream = filter_var($_POST['stream'] ,FILTER_SANITIZE_STRING);
  $Latitude = filter_var($_POST['lat'] , FILTER_SANITIZE_NUMBER_FLOAT , FILTER_FLAG_ALLOW_FRACTION);
  $Longitude = filter_var($_POST['lng'] , FILTER_SANITIZE_NUMBER_FLOAT , FILTER_FLAG_ALLOW_FRACTION);

  //Set upload variable to false //Not working: Aug 8 2017
  $check = false;
    if (is_int($siteID)) {
    if (($siteID != null || $siteID != "") && strlen($siteID) == 5)
    {
      $query = "SELECT * FROM `Sites` WHERE siteID = $siteID";
      $results = mysqli_query($link, $query);
      echo "testing site";

      if ($results->num_rows > 0) 
      {
        echo "<script>siteError('True');</script";
            //echo "Site Already Exists";
        $check = false;
      } else 
      {

        $check = true;
      }
    }
  } else {
    echo "Not int"; //Call siteError().
    echo $test;
  }

    if ($check == true) 
    {
      $query = "INSERT INTO `Sites` (`SiteID` , `Description`, `Stream` , `Lat`,`Lng` , `Pictures` , `reportCards`)
      VALUES ('$siteID', '$Description', '$Stream', '$Latitude' , '$Longitude' , '$imageTmpName' , '$reportTmpName')";
      $result = mysqli_query($link, $query);
      if (!$result) 
      {
        $message = "Sorry, we were unable to upload your data.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        exit;
      } else 
      {
           // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.\n";

  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $image_file) && move_uploaded_file($_FILES["reportCard"]["tmp_name"], $report_file)) {
          rename($image_file, $imageName);
          rename($report_file,$reportName);
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }
        $message = "Thank you! We will look over your submission and add it to our database.";
       echo "<script type='text/javascript'>alert('$message');</script>";
      }
    }
  }
?>


  </body>

  <!-- Footer -->
  <div align = "center" id = "footer">
  <p>&copy <?php echo date("Y")?> McMaster University</p>
  </div>

</html>