<?php
// Require https
if ($_SERVER['HTTPS'] != "on") {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}
?>
<!-- Developed by Cameron Parker - 2017 -->
<!DOCTYPE html>
<html>
  <head>
    <link rel = "stylesheet" type = "text/css" href = "stylesheets/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type = "text/javascript" src = "validate.js"</script>
    <script type = "text/javascript" src = "listErrors.js"</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src = "node_modules/chart.js/dist/Chart.js"></script>
    <script type = "text/javascript">
      function toggleDisabled(elem1 , elem2 , elem3 , value)
      {
      	var element1 = document.getElementById(elem1);
      	var element2 = document.getElementById(elem2);
      	if (elem3 != "") 
      	{
      		var element3 = document.getElementById(elem3);
      	}

      	if (element1.value === value) 
      	{
      		console.log("toggling on");
      		element2.disabled = '';
      		if (elem3 != "") 
      		{
      			element3.disabled = '';
      		}
      	} else 
      	{
      		console.log("toggling off");
      		element2.disabled = 'true';
      		if (elem3 != "") 
      		{
      			element3.disabled = 'true';
      		}
      	}
      }
    </script>
    <script>
      //Function to disable a certain input if another input contains a value.
      function siteError($siteIDError) 
      {
      	var list = document.getElementById('errors');
      	if ($siteIDError == 'True') 
      	{
        	console.log("SiteID Not Valid");
        	error = "Please Enter A Valid Site ID";  
        }
        	var ulist = document.createElement('ul');
        	var err = document.createElement('li');
        	err.appendChild(document.createTextNode(error));
        	var add = ulist.appendChild(err);
        	list.appendChild(add);
      }
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
        xmlhttp.open("GET","getSite.php",true);
        xmlhttp.send();
      }
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
      require("credentials.php");
    	//Variables
    	//$dbase = 'db690177581';
    	//$dbuser = 'dbo690177581';
    	//$dbpass = 'EcologyLab';
    	//$link = mysqli_connect("db690177581.db.1and1.com", $dbuser, $dbpass, $dbase );
      $link = mysqli_connect($host, $username, $password, $database);

  	 if (!$link)
  	 { //Print error message
      	echo "Error: Unable to connect to MySQL." . PHP_EOL;
      	echo "Debugging err number: " . mysqli_connect_errno() . PHP_EOL;
      	exit;
  	 }

  	 //echo "A proper connection to MySQL was made!" . PHP_EOL;
  	 //echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
    ?>

    <div id = "header">
      <h1>Chlorophyll Submission Form</h1>
    </div>

    <div id = "errors">
    </div>

    <div id = "container">
      <form onsubmit = "return validate()" class="cf" action = "<?= $_SERVER['PHP_SELF'] ?>" method = "post" enctype = "multipart/form-data">
        <!-- Left side of inputs-->
        <div class="half left cf">
          <label for "name">Name</label>
          <input required name = "name" type="text" id="input-name" placeholder="Name*"  value = "<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>">

          <label for "affiliation">Affiliation</label>
          <input required name = "affiliation" type="text" id="input-affiliation" placeholder="Affiliation*"  value = "<?php echo isset($_POST['affiliation']) ? $_POST['affiliation'] : '' ?>">

          <label for "email">Email</label>
          <input required name = "email" type="email" id="input-email" placeholder="Email address*" value = "<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">

          <label for "timeExtracted">Time Extracted</label>
          <input  required name = "timeExtracted" type="number" min = "24" max = "120" id="input-timeExtracted" placeholder="Time Extracted (in hours)*" value = "<?php echo isset($_POST['timeExtracted']) ? $_POST['timeExtracted'] : '' ?>">
          <span class = "tooltiptext">Time rod spent in 10mL of acetone</span>
          
          <label for "blueValue">Blue Value</label>
          <input required name = "blueValue" type="number" min = "0" max = "65" id="input-blueValue" placeholder="Blue Value*" value = "<?php echo isset($_POST['blueValue']) ? $_POST['blueValue'] : '' ?>">

          <label for "rodLength">Rod Length</label>
          <input required name = "rodLength" type="number" min = "3" max = "10" id="input-rodLength" placeholder="Rod Length (in cm)*" value = "<?php echo isset($_POST['rodLength']) ? $_POST['rodLength'] : '' ?>">

          <label for "siteDescription">Site Description</label>
          <input required name = "siteDescription" type="text" id="input-siteDescription" placeholder="Site Description*" maxlength="100" value = "<?php echo isset($_POST['siteDescription']) ? $_POST['siteDescription'] : '' ?>">
        </div>

        <!-- Right side of inputs-->
        <div class="half right cf">
        	<label for "dateDeployed">Date Deployed</label>
          <input required title = "Date Deployed" name = "dateDeployed" type="date" id="input-dateDeployed" placeholder="Date Deployed*"  value = "<?php echo isset($_POST['dateDeployed']) ? $_POST['dateDeployed'] : '' ?>">

          <label for "dateCollected">Date Collected</label>
          <input required title = "Date Collected" name = "dateCollected" type="date" id="input-dateCollected" placeholder="Date Collected*" value = "<?php echo isset($_POST['dateCollected']) ? $_POST['dateCollected'] : '' ?>">

          <label for "habitat">Habitat Rod Was Located In</label>
          <select required title = "Habitat Rod Was Located In" name = "habitat" id = "input-habitat"  onChange = 'toggleDisabled("input-habitat" , "input-notes" , "" , "other")'>
          	<option disabled selected hidden value = "">Habitat Rod Was Located In</option>
          	<option value = "thalweg">Thalweg</option>
          	<option value = "riffle">Riffle</option>
          	<option value = "pool">Pool</option>
          	<option value = "other">Other (Describe in Notes)</option>
          </select>

          <label for "notes">Notes</label>
          <input disabled = "true" name="notes" type="text" id="input-notes" placeholder="Notes" maxlength="255" value = "<?php echo isset($_POST['notes']) ? $_POST['notes'] : '' ?>">

          <label for "siteID">Site ID</label>
          <input name = "siteID" type="text" id="input-siteID" onKeyup = 'toggleDisabled("input-siteID" , "input-lng" , "input-lat" , "")' placeholder="Site ID*" value = "" onfocus="displaySiteList()" onblur = "removeDiv('info' , 'siteData')">

          <label for "lat">Latitude</label>
          <input  default = "0" name="lat" type="number" min = "-180" max = "180" id="input-lat" placeholder="Latitude of Site" value = "<?php echo isset($_POST['lat']) ? $_POST['lat'] : '' ?>">

          <label for "lng">Longitude</label>
          <input  default = "0" name="lng" type="number" min = "-180" max = "180" id="input-lng" placeholder="Longitude of Site" value = "<?php echo isset($_POST['lng']) ? $_POST['lng'] : '' ?>">

        </div>
        <div id = "info">
        </div>
          <div id = "stats">
            <?php
              if ($_POST != null) 
              {
                $siteID = $_POST['siteID'];
                $blueValue = $_POST['blueValue'];
              
              if ($_POST['submit'] != null) 
              {

                $query = "SELECT AVG(Chlorophyll) As `Chlorophyll` FROM UserData WHERE SiteID = $siteID;";
                $result = mysqli_query($link, $query);
                $row = @mysqli_fetch_assoc($result);
                echo "Your Blue Value is: " . $blueValue . "<br />";
                echo "Average Blue Value is: " . $row['Chlorophyll'] ;

              }
              }
            ?>
          </div>
        <input name = "submit" type="submit" value="Submit" id="input-submit">
      </form>
    </div>

    <div id = "goToMap">
      <a href = "map.html" class = "button">Go To Map</a>
    </div>

  <?php
  //Upload to a database
  if ($_POST != null) 
  {
    //Variables
    $name = $_POST['name'];
    $affiliation = $_POST['affiliation'];
    $email = $_POST['email'];
    $siteID = $_POST['siteID'];
    $timeExtracted  = $_POST['timeExtracted'];
    $dateDeployed = $_POST['dateDeployed'];
    $dateCollected  = $_POST['dateCollected'];
    $habitat = $_POST['habitat'];
    $rodLength = $_POST['rodLength'];
    $notes = $_POST['notes'];
    $blueValue = $_POST['blueValue'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $siteDescription = $_POST['siteDescription'];
    
    if ($_POST['submit'] != null) 
    {
    	$check = false;
      //Chlorophyll calculation using Nix sensor's blue value
    	$sum = (81.181645 - (1.4625132 * $blueValue)) + (0.032159 * POW(($blueValue - 43.6545),2));

    	if ($siteID != null || $siteID != "")
    	{
    		$query = "SELECT * FROM `Sites` WHERE siteID = $siteID";
    		$results = mysqli_query($link, $query);

    		if ($results->num_rows <= 0) 
    		{
    			echo "<script>siteError('True');</script";
    			$check = false;
    		} else 
        {
    			$check = true;
    		}
    	}

    	if ($lat == null || $lat == "") 
      {
    		$lat = 0;
    	}
    	if ($lng == null || $lng == "") 
      {
    		$lng = 0;
    	}

    	if ($check == true) 
    	{
  	    $query = "INSERT INTO `UserData` (`Name` , `Email`, `SiteID` , `Notes`,`Affiliation` , `TimeExtracted` , `DateCollected` , `DateDeployed` , `Habitat` , `RodLength` , `BlueValue` , `Chlorophyll`, `Lat` , `Lng` , `SiteDescription`)
  	    VALUES ('$name', '$email', '$siteID', '$notes' , '$affiliation' , '$timeExtracted' , '$dateCollected' , '$dateDeployed' , '$habitat' , '$rodLength' , '$blueValue', '$sum' , '$lat' , '$lng' , '$siteDescription')";
  	    $result = mysqli_query($link, $query);
  	  	if (!$result) 
  	  	{
  	      echo "Error: Unable to query database." . PHP_EOL;
  	      echo "Debugging errno: " . mysqli_error($link) . PHP_EOL;
  	      $message = "Sorry, we were unable to upload your data.";
  	      echo "<script type='text/javascript'>alert('$message');</script>";
  	      exit;
  	  	} else 
  	  	{
  	      $message = "Thank you! We will look over your submission and add it to our database.";
  	      echo "<script type='text/javascript'>alert('$message');</script>";
  	  	}
  		}
  	}
    /* //Prints out the results from a SQL query.
    while ($row = mysqli_fetch_assoc($result)) {
     echo $row['Name'] . ' ' . $row['Email'] . ' ' . $row['Site ID'] . ' ' . $row['notes'] .'<br />';
    } */
  }
  mysqli_close($link); //close the connection
  ?>

  </body>

  <div align = "center" id = "footer">
  <p>&copy <?php echo date("Y")?> McMaster University</p>
  </div>

</html>