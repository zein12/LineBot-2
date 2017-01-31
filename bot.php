<?php
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;

$path = __DIR__ . '/vendor/autoload.php';
require_once $path;

$httpClient = new CurlHTTPClient('7d/5ZTMP4E4lxZDhsIeUFlZrD1I38QFKdZC8V6uBg5Sb4pQ1zbc5KaKbrjnz3XjlKqr2uNyWIObJD92hU0yaLO6AslpPjDyjN258d4oRcwyHP9WsAoEULfZEYr5qhewphqLCr37ewhMUtuIhs1F+twdB04t89/1O/w1cDnyilFU=');
$bot = new LINEBot($httpClient, ['channelSecret' => 'a787beedee0c166ef92af739d47143e4']);
$mid = '1498968134';

$postdata = file_get_contents("php://input");
// Parse JSON
$events = json_decode($postdata, true);

if(!is_null($events['events'])) {
	foreach ($events['events'] as $event) {
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			$text = $event['message']['text'];
			
			if(strpos($text, 'text') !== false){
				$MessageBuilder = new TextMessageBuilder('Hello...');
				$response = $bot->pushMessage($mid, $MessageBuilder);
				$MessageBuilder = new TextMessageBuilder('How are you?');
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'image') !== false){
				$MessageBuilder = new ImageMessageBuilder(
					'https://upload.wikimedia.org/wikipedia/commons/b/b4/JPEG_example_JPG_RIP_100.jpg',
					'https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg'
				);
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'video') !== false){
				$MessageBuilder = new VideoMessageBuilder(
					'https://example.com/original.mp4',
					'https://upload.wikimedia.org/wikipedia/commons/a/ac/Large_format_camera_lens.jpg'
				);
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'audio') !== false){
				$MessageBuilder = new AudioMessageBuilder('https://example.com/original.m4a',240000);
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'location') !== false){
				$MessageBuilder = new LocationMessageBuilder(
					'my location',
					'Tokyo Shibuya',
					35.6566285,
					139.6999638
				);
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'sticker') !== false){
				$MessageBuilder = new StickerMessageBuilder(1,1);
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
			if(strpos($text, 'confirm') !== false){
				$Message[] = new MessageTemplateActionBuilder('Yes','yes');
				$Message[] = new MessageTemplateActionBuilder('No','no');
				$Template = new ConfirmTemplateBuilder('Are you Sure??',$Message);
				
				$MessageBuilder = new TemplateMessageBuilder('please confirm on your smartphone.',$Template);
				$response = $bot->pushMessage($mid, $MessageBuilder);				
			}
			if(strpos($text, 'button') !== false){
				$Message[] = new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=123');
				$Message[] = new PostbackTemplateActionBuilder('Add', 'action=add&itemid=123');
				$Message[] = new UriTemplateActionBuilder('Detail', 'http://example.com/page/123');
				$Template = new ButtonTemplateBuilder(
					'https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg',
					'template title',
					'button template',
					$Message
				);
				
				$MessageBuilder = new TemplateMessageBuilder('button template.',$Template);
				$response = $bot->pushMessage($mid, $MessageBuilder);				
			}
			if(strpos($text, 'map') !== false){
				$AreaUri = new AreaBuilder(0,0,520,1040);
				$AreaMessage = new AreaBuilder(520,0,520,1040);
				$Action[] = new ImagemapUriActionBuilder('https://example.com/',$AreaUri);
				$Action[] = new ImagemapMessageActionBuilder('hello',$AreaMessage);
				$BaseSize = new BaseSizeBuilder(1040,1040);
				
				$MessageBuilder = new ImagemapMessageBuilder(
					'https://example.com/bot/images/rm001',
					'ImageMap',
					$BaseSize,
					$Action
				);
				$response = $bot->pushMessage($mid, $MessageBuilder);
			}
		}
	}	
}