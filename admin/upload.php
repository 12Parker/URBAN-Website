<?php
	require("../php/credentials.php");

		//Return to index.php after
	  if(isset($_REQUEST["destination"])){
      header("Location: {$_REQUEST["destination"]}");
  }else if(isset($_SERVER["HTTP_REFERER"])){
      header("Location: {$_SERVER["HTTP_REFERER"]}");
  }else{
       /* some fallback, maybe redirect to index.php */
  }


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

  //Set upload variable to false
  $check = false;
  	if (is_int($siteID)) {
  	if (($siteID != null || $siteID != "") && $siteID.Length == 5)
  	{
  		$query = "SELECT * FROM `Sites` WHERE siteID = $siteID";
  		$results = mysqli_query($link, $query);

  		if ($results->num_rows > 0) 
  		{
  			//echo "<script>siteError('True');</script";
        		echo "Site Exists";
  			$check = false;
  		} else 
      {

  			$check = true;
  		}
  	}
  } else {
  	
  }

  	if ($check == true) 
  	{
	    $query = "INSERT INTO `Sites` (`SiteID` , `Description`, `Stream` , `Lat`,`Lng` , `Pictures` , `reportCards`)
	    VALUES ('$siteID', '$Description', '$Stream', '$Latitude' , '$Longitude' , '$imageTmpName' , '$reportTmpName')";
	    $result = mysqli_query($link, $query);
	  	if (!$result) 
	  	{
	      $message = "Sorry, we were unable to upload your data.";
	      //echo "<script type='text/javascript'>alert('$message');</script>";
	      exit;
	  	} else 
	  	{
	  			 // Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	   // echo "Sorry, your file was not uploaded.\n";

	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["picture"]["tmp_name"], $image_file) && move_uploaded_file($_FILES["reportCard"]["tmp_name"], $report_file)) {
	    		rename($image_file, $imageName);
	    		rename($report_file,$reportName);
	    } else {
	        //echo "Sorry, there was an error uploading your file.";
	    }
	}
	      $message = "Thank you! We will look over your submission and add it to our database.";
	     echo "<script type='text/javascript'>alert('$message');</script>";
	  	}
		}
?>