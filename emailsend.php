<?php
session_start();
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


echo "Original URL: " . $url . "<br/>";
echo "Redirected URL: " . $redirectedurl . "<br/>";

?>