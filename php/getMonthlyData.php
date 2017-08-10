<?php
	require("credentials.php");
	//setting header to json
	header('Content-Type: application/json');

	// Opens a connection to a MySQL server
	$connection=mysqli_connect($host, $username, $password, $database);
	
	if (!$connection) { 
		die('Not connected : ' . mysql_error());
	}

	//query to get data from the table
	$siteID = $_GET['siteName'];
	$query = ("SELECT AVG(Chlorophyll) as 'Chlorophyll' , MONTHNAME(DateDeployed) as 'Month'
	FROM UserData
	WHERE DATE_FORMAT(CURDATE() - INTERVAL 11 MONTH, '%Y-%m')
	 <= DATE_FORMAT(`DateDeployed`, '%Y-%m') AND SiteID = $siteID
	GROUP BY MONTH(DateDeployed);");

	$result = mysqli_query($connection , $query);
	
	if (!$result) {
	  die('Invalid query: ' . mysqli_error());
	}

	//loop through the returned data
	$data = array();
	
	foreach ($result as $row) {
		$data[] = $row;
	}

	//now print the data
	print json_encode($data);
?>