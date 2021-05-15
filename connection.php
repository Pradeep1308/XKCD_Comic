<?php 
$conn = mysqli_connect('localhost', 'root', '');
$sql = "CREATE DATABASE IF NOT EXISTS userform";
$conn->query($sql);
$con= mysqli_connect('localhost', 'root', '','userform');
$sql="CREATE TABLE IF NOT EXISTS `usertable` (
    `id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `code` mediumint(50) NOT NULL,
    `status` text NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$con->query($sql);



?>