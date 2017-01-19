<?php
// Show all errors for testing
error_reporting(E_ALL);

// SDK is installed via composer
require_once __DIR__ . "/vendor/autoload.php";

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
$access_token = 'wzwpbz9tZWCSPDrTFYf+APzByZ3jnlV259OV13WiCcsBXMftEVvi/OzVdEy8C31CYj4iA6GdPwQ5QCBnrJPKTNC4IcxZlr4bJwIVRAPd1FlWnDG8ThGjHWY4ZIOD1V/DhshZVuUJUv+YfDrLgh6xtgdB04t89/1O/w1cDnyilFU=';
// Set these
$config = [
    'channelId' => '1496021296',
    'channelSecret' => '515995d49d4801e7c580b8c914709b35',
    'channelMid' => 'Ubb0233685f6c43ad7af9f72476d67f16',
];
$sdk = new LINEBot($config, new CurlHTTPClient($config));

$postdata = @file_get_contents("php://input");
$messages = $sdk->createReceivesFromJSON($postdata);

// Verify the signature
// REF: http://line.github.io/line-bot-api-doc/en/api/callback/post.html#signature-verification
$sigheader = 'X-LINE-ChannelSignature';
// REF: http://stackoverflow.com/a/541450
$signature = @$_SERVER[ 'HTTP_'.strtoupper(str_replace('-','_',$sigheader)) ];
if($signature && $sdk->validateSignature($postdata, $signature)) {
    // Next, extract the messages
    if(is_array($messages)) {
        foreach ($messages as $message) {
            if ($message instanceof LINEBot\Receive\Message\Text) {
                $text = $message->getText();
                if ($text == "mid") {
                    $fromMid = $message->getFromMid();

                    // Send the mid back to the sender and check if the message was delivered
                    $result = $sdk->sendText([$fromMid], 'mid: ' . $fromMid);
                    if(!$result instanceof LINE\LINEBot\Response\SucceededResponse) {
                        error_log('LINE error: ' . json_encode($result));
                    }
                } else {
                    // Process normally, or do nothing
                }
            } else {
                // Process other types of LINE messages like image, video, sticker, etc.
            }
        }
    }else{
		$messages['type'] = 'text';
		$messages['text'] = 'Hello';
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
} else {
    error_log('LINE signatures didn\'t match');
}