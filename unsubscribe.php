<?php
session_start();
require "connection.php";
$email= $_GET["emailid"];
//echo $email;
$sql = "DELETE FROM usertable WHERE email='$email'";
if ($con->query($sql) === TRUE) {
  echo "unsubscribed succesfully and see you soon \u{1F600}";
} else {
  echo "Error deleting record: " . $con->error;
}
?>