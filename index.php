<?php
//use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
//use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
//use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;

$Message[] = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('Yes','yes');
$Message[] = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('No','no');
$Template = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder('Are you Sure??',$Message);

$MessageBuilder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('this is a confirm template.', $Template);

print_r($MessageBuilder);