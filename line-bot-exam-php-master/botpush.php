<?php



require "vendor/autoload.php";

$access_token = 'Gppzd6Y3lg6XHyA4wBZ0zWdyWmlqeDYBCxayHBYC8r8GnLXUSy2vJ9kN/NEdcdWqdoVJiZlgR3is39pmvR7OvjFEwGpMbheQ8cifL+ETAhZaz6DrrbVV1pT15YKjCXfhH0JI7sdaTS44/6vVtp1yLAdB04t89/1O/w1cDnyilFU=';

$channelSecret = 'f0c63c7170eab4b9f8027cf92c515a81';

$pushID = 'U0496f551224258abfc0eeb41da0a4e30';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello world');
$response = $bot->pushMessage($pushID, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();







