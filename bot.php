<?php
$path = __DIR__ . '/vendor/autoload.php';
require_once $path;

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('wzwpbz9tZWCSPDrTFYf+APzByZ3jnlV259OV13WiCcsBXMftEVvi/OzVdEy8C31CYj4iA6GdPwQ5QCBnrJPKTNC4IcxZlr4bJwIVRAPd1FlWnDG8ThGjHWY4ZIOD1V/DhshZVuUJUv+YfDrLgh6xtgdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '515995d49d4801e7c580b8c914709b35']);

$postdata = file_get_contents("php://input");
$messages = $bot->createReceivesFromJSON($postdata);

if(is_array($messages)) {

	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('helloooo');
	$response = $bot->pushMessage('Ubb0233685f6c43ad7af9f72476d67f16', $textMessageBuilder);
}
else{
	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hi!!');
	$response = $bot->pushMessage('Ubb0233685f6c43ad7af9f72476d67f16', $textMessageBuilder);
}

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
