<!-Color name , description, blue value auto read from excel->

<!DOCTYPE html>
<html>
<head>
<link rel = "stylesheet" type = "text/css" href = "stylesheets/main.css">
</head>
<title>Urban Chlorophyll Data</title>
<body>

<?php
//Step1
 $dbase = 'test';
 $dbuser = 'cameron';
 $dbpass = 'EcologyLab';
 $db = mysqli_connect('localhost', $dbuser, $dbpass)
 if ($db == false) 
{
  $status = 'Could not connect: ' . mysql_error();
  echo $status;
  die();
}
if (! @mysql_select_db($dbase) ) 
{
  $status = 'Could not select database';
  echo $status;
  die();
}
echo "<h1> Testing </h1>";
?>

<h1>Chlorophyl Submission Form</h1>
<form class="cf" action = "upload.php" method = "post" enctype = "multipart/form-data">
  <div class="half left cf">
    <input type="text" id="input-name" placeholder="Name">
    <input type="email" id="input-email" placeholder="Email address">
    <input type="text" id="input-siteID" placeholder="Site ID">
  </div>
  <div class="half right cf">
    <textarea name="message" type="text" id="input-message" placeholder="Message"></textarea>
    <input type = "file" name = "fileToUpload" id = "fileToUpload">
  </div>  
  <input type="submit" value="Submit" id="input-submit">
</form>

<?php
//Step2
$query = "SELECT * FROM `Testing";
mysqli_query($db, $query) or die('Error querying database.');

$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);

while ($row = mysqli_fetch_array($result)) {
 echo $row['first_name'] . ' ' . $row['last_name'] . ': ' . $row['email'] . ' ' . $row['city'] .'<br />';
}
?>
</body>
<?php echo "<h1> Test </h1>" ?>
<html>