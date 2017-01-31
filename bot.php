<?php

$access_token = '7d/5ZTMP4E4lxZDhsIeUFlZrD1I38QFKdZC8V6uBg5Sb4pQ1zbc5KaKbrjnz3XjlKqr2uNyWIObJD92hU0yaLO6AslpPjDyjN258d4oRcwyHP9WsAoEULfZEYr5qhewphqLCr37ewhMUtuIhs1F+twdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;