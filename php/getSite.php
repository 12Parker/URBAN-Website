<?php
  	//Variables
  	$dbase = 'db690177581';
  	$dbuser = 'dbo690177581';
  	$dbpass = 'EcologyLab';
  	$link = mysqli_connect("db690177581.db.1and1.com", $dbuser, $dbpass, $dbase );

	if (!$link)
	{ //Print error message
    	echo "Error: Unable to connect to MySQL." . PHP_EOL;
    	echo "Debugging err number: " . mysqli_connect_errno() . PHP_EOL;
    	exit;
	}

	$query = "SELECT `SiteID` , `Stream` FROM `Sites`;";
  	$result = mysqli_query($link, $query);
  	echo "<br /><div id  = \"siteData\">";
  	echo "<p><u>List of Valid Sites</u></p>";
  	while ($row = mysqli_fetch_array($result)) {
  		echo $row['SiteID'] . " = " . $row['Stream'] . "<br / >"  ;
  	}
  	echo "</div>";
  	mysqli_close($link);
?>