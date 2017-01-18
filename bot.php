<?php
require_once('vendor\linecorp\line-bot-sdk\line-bot-sdk-tiny\LINEBotTiny.php');

// Get POST body content
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('wzwpbz9tZWCSPDrTFYf+APzByZ3jnlV259OV13WiCcsBXMftEVvi/OzVdEy8C31CYj4iA6GdPwQ5QCBnrJPKTNC4IcxZlr4bJwIVRAPd1FlWnDG8ThGjHWY4ZIOD1V/DhshZVuUJUv+YfDrLgh6xtgdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '515995d49d4801e7c580b8c914709b35']);
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	$client = new LINEBotTiny($httpClient, $bot);
	foreach ($client->parseEvents() as $event) {
		switch ($event['type']) {
			case 'message':
				$message = $event['message'];
				switch ($message['type']) {
					case 'text':
						$client->replyMessage(array(
							'replyToken' => $event['replyToken'],
							'messages' => array(
								array(
									'type' => 'text',
									'text' => $message['text']
								)
							)
						));
						break;
					default:
						error_log("Unsupporeted message type: " . $message['type']);
						break;
				}
				break;
			default:
				error_log("Unsupporeted event type: " . $event['type']);
				break;
		}
	}
}
echo 'OK!!';