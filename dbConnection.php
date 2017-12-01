
<?php

$host = "cosc304.ok.ubc.ca/";
$user = "zdupont";
$database = "cosc304.ok.ubc.ca/db_" . $user;
$password = "52122158";

$connection = mysqli_connect($host, $user, $password, $database);

$error = mysqli_connect_error();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}


?>
