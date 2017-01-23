<?php
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;

$path = __DIR__ . '/vendor/autoload.php';
require_once $path;

$Message[] = new MessageTemplateActionBuilder('Yes','yes');
$Message[] = new MessageTemplateActionBuilder('No','no');
$Template = new ConfirmTemplateBuilder('Are you Sure??',$Message);

$MessageBuilder = new TemplateMessageBuilder('this is a confirm template.', new ConfirmTemplateBuilder('Are you Sure??',$Message));

print_r($MessageBuilder);