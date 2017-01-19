<?php
// Show all errors for testing
error_reporting(E_ALL);

// SDK is installed via composer
require_once __DIR__ . "/vendor/autoload.php";

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

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
		$result = $sdk->sendText(['555'], '555');
		if(!$result instanceof LINE\LINEBot\Response\SucceededResponse) {
			error_log('LINE error: ' . json_encode($result));
		}
	}
} else {
    error_log('LINE signatures didn\'t match');
}