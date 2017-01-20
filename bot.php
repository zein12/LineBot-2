<?php
$path = __DIR__ . '/vendor/autoload.php';
require_once $path;

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('wzwpbz9tZWCSPDrTFYf+APzByZ3jnlV259OV13WiCcsBXMftEVvi/OzVdEy8C31CYj4iA6GdPwQ5QCBnrJPKTNC4IcxZlr4bJwIVRAPd1FlWnDG8ThGjHWY4ZIOD1V/DhshZVuUJUv+YfDrLgh6xtgdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '515995d49d4801e7c580b8c914709b35']);
$mid = 'Ubb0233685f6c43ad7af9f72476d67f16';

$postdata = file_get_contents("php://input");
// Parse JSON
$events = json_decode($postdata, true);

if(!is_null($events['events'])) {
	foreach ($events['events'] as $event) {
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			$text = $event['message']['text'];
			
			if(strpos($text, 'text') !== false){
				$MessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('Hello.');
				$response = $bot->pushMessage($mid, $MessageBuilder);
				$MessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('How are you??');
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'image') !== false){
				$MessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder('https://upload.wikimedia.org/wikipedia/commons/b/b4/JPEG_example_JPG_RIP_100.jpg','https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg');
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'video') !== false){
				$MessageBuilder = new \LINE\LINEBot\MessageBuilder\VideoMessageBuilder('https://example.com/original.mp4','https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg');
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'audio') !== false){
				$MessageBuilder = new \LINE\LINEBot\MessageBuilder\AudioMessageBuilder('https://example.com/original.m4a',240000);
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'location') !== false){
				$MessageBuilder = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder('my location','〒150-0002 東京都渋谷区渋谷２丁目２１−１',35.65910807942215,139.70372892916203);
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'sticker') !== false){
				$MessageBuilder = new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1,1);
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'tem') !== false){
				$Message1 = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('Yes','yes');
				$Message2 = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('No','no');
				$ActionTemplate = \LINE\LINEBot\TemplateActionBuilder($Message1,$Message2);
				$Template = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder('Are you Sure',[$Message1,$Message2]);
				
				$MessageBuilder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('this is a confirm template', $Template);
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
		}
	}	
}
$Message1 = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('Yes','yes');
$Message2 = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('No','no');
$Template = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder('Are you Sure',[$Message1,$Message2]);
print_r($Template);