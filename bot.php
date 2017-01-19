<?php
$path = __DIR__ . '/vendor/autoload.php';
require_once $path;

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('wzwpbz9tZWCSPDrTFYf+APzByZ3jnlV259OV13WiCcsBXMftEVvi/OzVdEy8C31CYj4iA6GdPwQ5QCBnrJPKTNC4IcxZlr4bJwIVRAPd1FlWnDG8ThGjHWY4ZIOD1V/DhshZVuUJUv+YfDrLgh6xtgdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '515995d49d4801e7c580b8c914709b35']);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->pushMessage('https://api.line.me/v2/bot/message/reply', $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();