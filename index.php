<?php
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;

$Message[] = new MessageTemplateActionBuilder('Yes','yes');
$Message[] = new MessageTemplateActionBuilder('No','no');
$Template = new ConfirmTemplateBuilder('Are you Sure??',$Message);

$MessageBuilder = new TemplateMessageBuilder('this is a confirm template.', $Template);

print_r($MessageBuilder);