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
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;

$path = __DIR__ . '/vendor/autoload.php';
require_once $path;

$httpClient = new CurlHTTPClient('3/cEBpOR0mjAMUtnHKrSrx3N6FnMVNPYfXBIwMO6HNGaljxuxTxZz2fGrmZYFwqfV3dvAWMa7FEGrmOONfbZ7or1wxYgpjbtFMS0Mkk+RftjvYSrUpThxAHGiivf2M662z2zM5P8BSKby0dJiBG3GQdB04t89/1O/w1cDnyilFU=');
$bot = new LINEBot($httpClient, ['channelSecret' => 'a6b4b1a80d9f25eb0a719fc92cef7d86']);

$postdata = file_get_contents("php://input");
// Parse JSON
$events = json_decode($postdata, true);

if(!is_null($events['events'])) {
	foreach ($events['events'] as $event) {
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			$text = $event['message']['text'];
			$replyToken = $event['replyToken'];
			
			if(strpos(strtolower($text), 'hi') !== false || strpos(strtolower($text), 'hello') !== false){
				$MessageBuilder = new TextMessageBuilder('Hello!!','How are you?');
				$response = $bot->replyMessage($replyToken, $MessageBuilder);
			}
			if(strpos(strtolower($text), 'fine') !== false || strpos(strtolower($text), 'good') !== false){
				if(strpos(strtolower($text), 'you')){
					if((strpos(strtolower($text), 'how') && strpos(strtolower($text), 'are')) || strpos(strtolower($text), 'and')){
						$MessageBuilder = new TextMessageBuilder("I'm fine.");
						$response = $bot->replyMessage($replyToken, $MessageBuilder);
					}
				}
				else{
					$MessageBuilder = new TextMessageBuilder("OK.");
					$response = $bot->replyMessage($replyToken, $MessageBuilder);
				}
			}
			if(strpos(strtolower($text), 'image') !== false){
				$MessageBuilder = new ImageMessageBuilder(
					'https://upload.wikimedia.org/wikipedia/commons/b/b4/JPEG_example_JPG_RIP_100.jpg',
					'https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg'
				);
				$response = $bot->replyMessage($replyToken, $MessageBuilder);
			}
			if(strpos(strtolower($text), 'video') !== false){
				$MessageBuilder = new VideoMessageBuilder(
					'https://example.com/original.mp4',
					'https://upload.wikimedia.org/wikipedia/commons/a/ac/Large_format_camera_lens.jpg'
				);
				$response = $bot->replyMessage($replyToken, $MessageBuilder);
			}
			if(strpos(strtolower($text), 'audio') !== false){
				$MessageBuilder = new AudioMessageBuilder('https://example.com/original.m4a',240000);
				$response = $bot->replyMessage($replyToken, $MessageBuilder);
			}
			if(strpos(strtolower($text), 'location') !== false){
				$MessageBuilder = new LocationMessageBuilder(
					'my location',
					'Tokyo Shibuya',
					35.6566285,
					139.6999638
				);
				$response = $bot->replyMessage($replyToken, $MessageBuilder);
			}
			if(strpos(strtolower($text), 'sticker') !== false){
				$MessageBuilder = new StickerMessageBuilder(1,1);
				$response = $bot->replyMessage($replyToken, $MessageBuilder);
			}
			if(strpos(strtolower($text), 'confirm') !== false){
				$Message[] = new MessageTemplateActionBuilder('Yes','yes');
				$Message[] = new MessageTemplateActionBuilder('No','no');
				$Template = new ConfirmTemplateBuilder('Are you Sure??',$Message);
				
				$MessageBuilder = new TemplateMessageBuilder('Confirm on your smartphone.',$Template);
				$response = $bot->replyMessage($replyToken, $MessageBuilder);				
			}
			if(strpos(strtolower($text), 'button') !== false){
				$Message1 = new PostbackTemplateActionBuilder('Postback', 'post=back');
				$Message2 = new MessageTemplateActionBuilder('message', 'test message');
				$Message3 = new UriTemplateActionBuilder('Uri', 'https://upload.wikimedia.org/wikipedia/commons/b/b4/JPEG_example_JPG_RIP_100.jpg');
				$Template = new ButtonTemplateBuilder(
					'template title',
					'button template',
					'https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg',
					[$Message1,$Message2,$Message3]
				);
				
				$MessageBuilder = new TemplateMessageBuilder('Button on your smartphone.',$Template);
				$response = $bot->replyMessage($replyToken, $MessageBuilder);				
			}
			if(strpos(strtolower($text), 'car') !== false){
				$Message11 = new PostbackTemplateActionBuilder('Postback1', 'post=back');
				$Message12 = new MessageTemplateActionBuilder('Message1', 'test message');
				$Message13 = new UriTemplateActionBuilder('Uri1', 'https://upload.wikimedia.org/wikipedia/commons/b/b4/JPEG_example_JPG_RIP_100.jpg');
				$Column1 = new CarouselColumnTemplateBuilder(
					'title1',
					'text1',
					'https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg',
					[$Message11,$Message12,$Message13]
				);
				$Message21 = new PostbackTemplateActionBuilder('Postback2', 'post=back');
				$Message22 = new MessageTemplateActionBuilder('Message2', 'test message');
				$Message23 = new UriTemplateActionBuilder('Uri2', 'https://upload.wikimedia.org/wikipedia/commons/b/b4/JPEG_example_JPG_RIP_100.jpg');
				$Column2 = new CarouselColumnTemplateBuilder(
					'title2',
					'text2',
					'https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg',
					[$Message21,$Message22,$Message23]
				);
				$Template = new CarouselTemplateBuilder([$Column1,$Column2]);
				
				$MessageBuilder = new TemplateMessageBuilder('Carousel on your smartphone.',$Template);
				$response = $bot->replyMessage($replyToken, $MessageBuilder);				
			}
			if(strpos(strtolower($text), 'map') !== false){
				$AreaUri = new AreaBuilder(0, 0, 1040, 520);
				$AreaMessage = new AreaBuilder(0, 520, 1040, 520);
				$Action1 = new ImagemapUriActionBuilder('https://pixabay.com/en/background-frame-food-kitchen-cook-1932466/',$AreaUri);
				$Action2 = new ImagemapMessageActionBuilder('Fortune',$AreaMessage);
				$BaseSize = new BaseSizeBuilder(1040, 1040);
				
				$MessageBuilder = new ImagemapMessageBuilder(
					'https://pixabay.com/en/background-frame-food-kitchen-cook-1932466/',
					'alt test',
					$BaseSize,
					[$Action1,$Action2]
				);
				$response = $bot->replyMessage($replyToken, $MessageBuilder);
			}			
			if(strpos(strtolower($text), 'multi') !== false){
				$MessageBuilder = (new MultiMessageBuilder())
					->add(new TextMessageBuilder('text1', 'text2'))
					->add(new AudioMessageBuilder('https://example.com/audio.mp4', 1000));
				$response = $bot->replyMessage($replyToken, $MessageBuilder);
			}
		}
	}	
}echo 'OK';
