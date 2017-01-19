<?php

error_reporting(E_ALL);

// SDK is installed via composer
require_once __DIR__ . "/vendor/autoload.php";

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\GuzzleHTTPClient;

// Set these
$config = [
    'channelId' => 'wzwpbz9tZWCSPDrTFYf+APzByZ3jnlV259OV13WiCcsBXMftEVvi/OzVdEy8C31CYj4iA6GdPwQ5QCBnrJPKTNC4IcxZlr4bJwIVRAPd1FlWnDG8ThGjHWY4ZIOD1V/DhshZVuUJUv+YfDrLgh6xtgdB04t89/1O/w1cDnyilFU=',
    'channelSecret' => '515995d49d4801e7c580b8c914709b35',
];
$sdk = new LINEBot($config, new GuzzleHTTPClient($config));

$postdata = @file_get_contents("php://input");
$messages = $sdk->createReceivesFromJSON($postdata);

// Verify the signature
// REF: http://line.github.io/line-bot-api-doc/en/api/callback/post.html#signature-verification
$sigheader = 'LineBot';
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
                    $result = $sdk->sendText('555');
                    if(!$result instanceof LINE\LINEBot\Response\SucceededResponse) {
                        error_log('LINE error: ' . json_encode($result));
                    }
                }
            } else {
                $result = $sdk->sendText('666');
				if(!$result instanceof LINE\LINEBot\Response\SucceededResponse) {
					error_log('LINE error: ' . json_encode($result));
				}
            }
        }
    } // Else, error
} else {
    error_log('LINE signatures didn\'t match');
}