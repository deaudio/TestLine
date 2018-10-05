<?php
require('vendor/autoload.php');

define("LINE_MESSAGING_API_CHANNEL_SECRET", 'f0c63c7170eab4b9f8027cf92c515a81');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'Gppzd6Y3lg6XHyA4wBZ0zWdyWmlqeDYBCxayHBYC8r8GnLXUSy2vJ9kN/NEdcdWqdoVJiZlgR3is39pmvR7OvjFEwGpMbheQ8cifL+ETAhZaz6DrrbVV1pT15YKjCXfhH0JI7sdaTS44/6vVtp1yLAdB04t89/1O/w1cDnyilFU=');


use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\Constant\HTTPHeader;
use \LINE\LINEBot\Event\MessageEvent;
use \LINE\LINEBot\Event\MessageEvent\TextMessage;

$bot = new LINEBot(new CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN), [
            'channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET,
        ]);

$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

try  { 
    // Verify the content from Body and $ signature and get event if you succeed 
    $  event =  $ bot -> parseEventRequest ( $ body ,  $ signature );

    foreach ($events as $event) {
       if ($event instanceof FollowEvent) {
          continue;
       } else if ($event instanceof UnfollowEvent) {
          continue;
       } else if ($event instanceof PostbackEvent) {
          continue;
       } else if ($event instanceof TextMessage) {
          processTextMessageEvent($bot, $event);
          continue;
       } else if ($event instanceof LocationMessage) {
          replyTaberguList($bot, $event, $event->getLatitude(), $event->getLongitude()); //＊追加＊
          continue;
       } else {

       }

    }
} catch (Exception $e) {
  // none
}

function replyTaberguList($bot, $eventData, $lat, $lng) {
   $category = getCategory($eventData->getUserId());
   $taberoguList = getTaberoguData($category,$lat,$lng);
   if (count($taberoguList) === 0) {
     $bot->replyText($eventData->getReplyToken(),'The store could not be found. ' ); 
   }  The else  { 
     $ LineService  =  new new  LineMessageService ( LINE_MESSAGING_API_CHANNEL_TOKEN ); 
     $ res  =  $ LineService -> PostFlexMessage ( $ eventData -> GetReplyToken (),  $ TaberoguList ); 
     $ bot -> ReplyText ( $ event -> GetReplyToken (), $ res ); 
   } 
}

function getTaberoguData($cat,$lat,$lng) {
  $params = ['lat'=>$lat,'lng'=>$lng,'cat'=>$cat];
  $conn = curl_init();

  curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($conn, CURLOPT_POST, true);
  curl_setopt($conn, CURLOPT_URL,  '{秘密のAPI URL}');
  curl_setopt($conn, CURLOPT_POSTFIELDS, http_build_query($params));

  $result = curl_exec($conn);

  curl_close($conn);

  return json_decode($result);
}

function getCategory($user_id) {
  $conn = curl_init();
  $data = ['type'=>'get','user_id' => $user_id];
  curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($conn, CURLOPT_POST, true);
  curl_setopt($conn, CURLOPT_URL,  '{秘密のAPI URL}');
  curl_setopt($conn, CURLOPT_POSTFIELDS, http_build_query($data));

  $result = curl_exec($conn);

  curl_close($conn);

  $status = json_decode($result)->{'status'};
  if ($status === 'success') {
    return json_decode($result)->{'user'}->{'cat'};
  } else {
    return 1;
  }
}
