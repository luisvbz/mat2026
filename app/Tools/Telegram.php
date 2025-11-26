<?php


namespace App\Tools;

use React\EventLoop\Factory;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\TgLog;

class Telegram
{
    private $type;

  public static function meesage($message, $type = null)
  {


    $icons = ['danger' => '🚨', 'test' => '🖥'];

    $apiToken = '5178222445:AAH6nkdlfOFgdQLwrURsMB9SQ82jz4gys9Q';
    $loop = Factory::create();
    $tgLog = new TgLog($apiToken, new HttpClientRequestHandler($loop));
    $sendMessage = new SendMessage();
    $sendMessage->chat_id = '-1001634972970';
    //$sendMessage->chat_id = '1368428359';
    $sendMessage->parse_mode = 'HTML';
    if($type != null) {
      $sendMessage->text = <<<HTML
                     {$message} <b>{$icons[$type]}</b> 
                    HTML;
    }else {
      $sendMessage->text = <<<HTML
                     {$message} 
                    HTML;
    }

    $tgLog->performApiRequest($sendMessage);
    $loop->run();
  }

    public static function meesageIndividual($message, $id, $type = null)
    {


        $icons = ['danger' => '🚨', 'test' => '🖥'];

        $apiToken = '1584444429:AAGPh3Gc7vBxA5VGHNW3pZOhJCTUR4d5YiI';
        $loop = Factory::create();
        $tgLog = new TgLog($apiToken, new HttpClientRequestHandler($loop));
        $sendMessage = new SendMessage();
        $sendMessage->chat_id = $id;
        //$sendMessage->chat_id = '1368428359';
        $sendMessage->parse_mode = 'HTML';
        if($type != null) {
            $sendMessage->text = <<<HTML
                     {$message} <b>{$icons[$type]}</b> 
                    HTML;
        }else {
            $sendMessage->text = <<<HTML
                     {$message} 
                    HTML;
        }

        $tgLog->performApiRequest($sendMessage);
        $loop->run();
    }


}
