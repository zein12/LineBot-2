<?php
// Show all errors for testing
error_reporting(E_ALL);

// SDK is installed via composer
require_once __DIR__ . "/vendor/autoload.php";

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

// Set these
//$config = [
//    'channelId' => '1496021296',
//    'channelSecret' => '515995d49d4801e7c580b8c914709b35',
//    'channelMid' => 'Ubb0233685f6c43ad7af9f72476d67f16',
//];
//$sdk = new LINEBot($config, new CurlHTTPClient($config));

