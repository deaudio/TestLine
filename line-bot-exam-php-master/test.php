<?php
define("LINE_MESSAGING_API_CHANNEL_SECRET", 'f0c63c7170eab4b9f8027cf92c515a81');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'Gppzd6Y3lg6XHyA4wBZ0zWdyWmlqeDYBCxayHBYC8r8GnLXUSy2vJ9kN/NEdcdWqdoVJiZlgR3is39pmvR7OvjFEwGpMbheQ8cifL+ETAhZaz6DrrbVV1pT15YKjCXfhH0JI7sdaTS44/6vVtp1yLAdB04t89/1O/w1cDnyilFU=');


use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;

require('vendor/autoload.php');

$bot = new LINEBot(new CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN), [
            'channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET,
        ]);

$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

try  { 
    // Verify the content from Body and $ signature and get event if you succeed 
    $  event =  $ bot -> parseEventRequest ( $ body ,  $ signature );

    foreach ($events as $event) {
       if ($event instanceof TextMessage) {
          $bot->replyText($event->getReplyToken(), 'Yo Yo Yo');
          continue;
       }
    }
} catch (Exception $e) {
  // none
}
