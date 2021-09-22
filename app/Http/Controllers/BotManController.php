<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Facades\Log;

class BotManController extends Controller
{

 public function handle()
 {

  $config = [
   'telegram' => [
    'token' => '2033472918:AAHr6rvu5UuBLOXICJGYjysEFwxGqElqSOA',
   ],
  ];
  Drivers\DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
  $botman = BotManFactory::create($config);
  Log::info(print_r($botman, true));

  /**
   *  We are bringing in dilogflow middleware
   * then passing the message along to dialogFlow
   * currently we are passing everything along to
   * the middleware, we need to encapsulate the `hears`
   * commands in an if block then in the else hit the middle ware
   */

  /**
   * This if block is taking our message and handling it if the controller is set up to otherwise
   * we are receiving dialogFlow answer
   */
  $botman->hears('hello', function ($botman) {
   $botman->reply("<h1>Hello World</h1>");
  });

  
  $botman->listen();
 }


}
