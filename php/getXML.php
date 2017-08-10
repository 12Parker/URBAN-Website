<?php
  require("credentials.php");

  function parseToXML($htmlStr)
  {
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    return $xmlStr;
  }
  
  // Opens a connection to a MySQL server
  $connection=mysqli_connect($host, $username, $password, $database);
  if (!$connection) 
  { 
    die('Not connected : ' . mysql_error());
  }

  // Select all the rows in the markers table
  $query = "SELECT Sites.Lat, Sites.Lng, Sites.SiteID, Sites.Stream, AVG(UserData.Chlorophyll) AS 'Chlorophyll' , Sites.ReportCards , Sites.Pictures FROM Sites
  JOIN UserData on Sites.SiteID = UserData.SiteID
  GROUP BY Sites.SiteID;";

  $result = mysqli_query($connection , $query);
  if (!$result) 
  {
    die('Invalid query: ' . mysql_error());
  }
  
  header("Content-type: text/xml");
  
  // Start XML file, echo parent node
  echo '<markers>';
  
  // Iterate through the rows, printing XML nodes for each
  while ($row = @mysqli_fetch_assoc($result))
  {
    // Add to XML document node
    echo '<marker ';
    echo 'name="' . parseToXML($row['Stream']) . '" ';
    echo 'siteID="' . parseToXML($row['SiteID']) . '" ';
    echo 'lat="' . $row['Lat'] . '" ';
    echo 'lng="' . $row['Lng'] . '" ';
    echo 'chl="' . $row['Chlorophyll'] . '" ';
    echo 'reportCard="' . $row['ReportCards'] . '" ';
    echo 'pictures="' . $row['Pictures'] . '" ';
    echo '/>';
  }

  // End XML file
  echo '</markers>';

    $data = array();
  foreach ($result as $row) {
    $data[] = $row;
  }
  console.log($data);
?>