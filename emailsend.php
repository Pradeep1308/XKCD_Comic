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
$file = 'comicOFtheMoment.png';

$htmlContent='
<h1>'.$title.'</h1>
<img src='.$image.'><br>
<p>You can always <a href="https://localhost:4433/ss/login/unsubscribe.php?emailid='.$to.'">Unsubscribe</a></p>';
$headers = "From: $from"." <".$from.">";
$semi_rand = md5(time());  
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";  
//attaching file
if(!empty($file) > 0){ 
    if(is_file($file)){ 
        $message .= "--{$mime_boundary}\n"; 
        $fp =    @fopen($file,"rb"); 
        $data =  @fread($fp,filesize($file)); 
 
        @fclose($fp); 
        $data = chunk_split(base64_encode($data)); 
        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" .  
        "Content-Description: ".basename($file)."\n" . 
        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" .  
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
    } 
} 
$message .= "--{$mime_boundary}--"; 
$returnpath = "-f" . $from; 

//sending mail using mail()
mail($to, $subject, $message, $headers,$returnpath);
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
//creating and downloading the png to send as an attachement in mail
$img='comicOFtheMoment.png';
file_put_contents($img, file_get_contents($image));
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