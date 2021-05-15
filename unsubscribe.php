<?php
session_start();
require "connection.php";
$email= $_GET["emailid"];
//echo $email;
$sql = "DELETE FROM usertable WHERE email='$email'";
if ($con->query($sql) === TRUE) {
  echo "unsubscribed succesfully sad to see you leave";
} else {
  echo "Error deleting record: " . $con->error;
}
?>