<?php
	require("credentials.php");
	//Database Credentials
	$link=mysqli_connect($host, $username, $password, $database);

	if (!$link) { //Print error message
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging err number: " . mysqli_connect_errno() . PHP_EOL;
		exit;
	}

	$query = "SELECT `SiteID` , `Stream` FROM `Sites`;";
	$result = mysqli_query($link, $query);
	echo "<br /><div id  = \"siteData\">";
	echo "<p><u>List of Current Sites</u></p>";
	
	while ($row = mysqli_fetch_array($result)) {
		echo $row['SiteID'] . " = " . $row['Stream'] . "<br / >"  ;
	}
	
	echo "</div>";
	mysqli_close($link);
?>
