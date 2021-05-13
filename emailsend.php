<?php
session_start();
require "connection.php";
//function to fetch redirected random comic url from xkdc

function redirectedUrl($url)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
$html = curl_exec($ch);
$redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
$redirectedUrl .="info.0.json";
curl_close($ch);
return $redirectedUrl;
}
 // function to send mail
function sendmail($to,$image,$title)
{
$from="Pradeep";
$subject = 'Your Comic for the moment';

$htmlContent='
<h1>'.$title.'</h1>
<img src='.$image.'><br>';
$headers = "From: $from"." <".$from.">";
$semi_rand = md5(time());  
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";  
$message .= "--{$mime_boundary}--"; 

//sending mail using mail()
mail($to, $subject, $message, $headers);
}

$sql = "SELECT email FROM usertable";
$result = mysqli_query($con, $sql);

//url provided by xkcd which redirects to random comic
$url = 'https://c.xkcd.com/random/comic';
//redirectedUrl function called for fetching redirected url
$redirectedurl = redirectedUrl($url);
//fetching json from the redirected url
$json = file_get_contents($redirectedurl);
//json parsing data
$json = json_decode($json, true);
//fetching image and title link of random comic from parsed json data
$image=$json['img'];
$title=$json['title'];

//loop for sending comic to all email in db
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    sendmail($row["email"],$image,$title);
  }
}


//echo "Original URL: " . $url . "<br/>";
//echo "Redirected URL: " . $redirectedurl . "<br/>";

?>