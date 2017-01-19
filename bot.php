<?php
require_once('./vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	
	$httpClient = new CurlHTTPClient('wzwpbz9tZWCSPDrTFYf+APzByZ3jnlV259OV13WiCcsBXMftEVvi/OzVdEy8C31CYj4iA6GdPwQ5QCBnrJPKTNC4IcxZlr4bJwIVRAPd1FlWnDG8ThGjHWY4ZIOD1V/DhshZVuUJUv+YfDrLgh6xtgdB04t89/1O/w1cDnyilFU=');
	$bot = new LINEBot($httpClient, ['channelSecret' => '515995d49d4801e7c580b8c914709b35']);
	// Loop through each event
	foreach ($events['events'] as $event) {
		if ($event['type'] == 'message'){
			
			$replyToken = $event['replyToken'];
			
			$textMessageBuilder = new TextMessageBuilder('hello');
			$response = $bot->replyMessage($replyToken, $textMessageBuilder);
			if ($response->isSucceeded()) {
				echo 'Succeeded!';
				return;
			}
		}
	}
}
echo 'OK';