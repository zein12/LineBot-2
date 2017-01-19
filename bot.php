<?php
$access_token = 'wzwpbz9tZWCSPDrTFYf+APzByZ3jnlV259OV13WiCcsBXMftEVvi/OzVdEy8C31CYj4iA6GdPwQ5QCBnrJPKTNC4IcxZlr4bJwIVRAPd1FlWnDG8ThGjHWY4ZIOD1V/DhshZVuUJUv+YfDrLgh6xtgdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			$id = $event['source']['userId'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			
			// Build message to reply back
			if(strpos($text, 'h') !== false){
				$messages['type'] = 'text';
				$messages['text'] = $id;
			}else if(strpos($text, 'z') !== false){
				$messages[0]['type'] = 'text';
				$messages[0]['text'] = 'Hello';
				$messages[1]['type'] = 'text';
				$messages[1]['text'] = 'Hi';
			}else if($text == 'image' || $text == 'imag' || $text == 'img' || $text == 'png' || $text == 'jpg'){
				$messages = [
					'type' => 'image',
					'originalContentUrl' => 'https://upload.wikimedia.org/wikipedia/commons/b/b4/JPEG_example_JPG_RIP_100.jpg',
					'previewImageUrl' => 'https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg'
				];
			}else if($text == 'video' || $text == 'vid'){
				$messages = [
					'type' => 'video',
					'originalContentUrl' => 'https://example.com/original.mp4',
					'previewImageUrl' => 'https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg'
				];
			}else if($text == 'audio'){
				$messages = [
					'type' => 'audio',
					'originalContentUrl' => 'https://example.com/original.m4a',
					'duration' => 240000
				];
			}else if($text == 'location'){
				$messages = [
					'type' => 'location',
					'title' => 'my location',
					'address' => '〒150-0002 東京都渋谷区渋谷２丁目２１−１',
					'latitude' => 35.65910807942215,
					'longitude' => 139.70372892916203
				];
			}else if($text == 'sticker'){
				$messages = [
					'type' => 'sticker',
					'packageId' => '1',
					'stickerId' => '1'
				];
			}else{
				$messages = [
					'type' => 'text',
					'text' => '555'
				];
			}
			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . '\r\n';
		}
		if ($event['type'] == 'message' && $event['message']['type'] == 'sticker') {
			$replyToken = $event['replyToken'];
			$packageId = $event['message']['packageId'];
			$stickerId =  $event['message']['stickerId'];
			
			$messages = [
				'type' => 'sticker',
				'packageId' => $packageId,
				'stickerId' => $stickerId
			];
			
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
		}
	}
}
echo 'OK';