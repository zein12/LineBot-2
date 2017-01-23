<?php

use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;

$path = __DIR__ . '/vendor/autoload.php';
require_once $path;

$AreaUri = new AreaBuilder(0,0,520,1040);
$AreaMessage = new AreaBuilder(520,0,520,1040);
$Action[] = new ImagemapUriActionBuilder('https://en.wikipedia.org/wiki/Main_Page/',$AreaUri);
$Action[] = new ImagemapMessageActionBuilder('hello',$AreaMessage);
$BaseSize = new BaseSizeBuilder(1040,1040);

$MessageBuilder = new ImagemapMessageBuilder('https://upload.wikimedia.org/wikipedia/commons/a/ac/Large_format_camera_lens.jpg', 'ImageMap',$BaseSize,$Action);

print_r($MessageBuilder);