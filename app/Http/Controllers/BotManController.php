<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Log;

class BotManController extends Controller
{

 public function handle()
 {

  $config = [
   'telegram' => [
    'token' => env('TELEGRAM_TOKEN'),
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
   $botman->reply("We are hitting Laravel with telegram");
  });

  $botman->hears('buttons', function ($botman) {
   $this->questionTemplate($botman);
  });

  $botman->hears('hours', function ($botman) {
   $botman->reply("We are hitting hours Laravel with telegram");
   $this->questionTemplate($botman);

  });

  $botman->hears('location', function ($botman) {
   $botman->reply("We are hitting location Laravel with telegram");
   $this->questionTemplate($botman);

  });

  $botman->hears('feedback', function ($botman) {
   $botman->reply("We are hitting feedback Laravel with telegram");
   $this->questionTemplate($botman);

  });

  $botman->hears('specials', function ($botman) {
   $botman->reply("We are hitting special Laravel with telegram");
   $this->questionTemplate($botman);

  });

  $botman->hears('menu', function ($botman) {
   $botman->reply("We are hitting menu Laravel with telegram");
   $this->questionTemplate($botman);

  });

  $botman->listen();
 }
 public function questionTemplate($botman)
 {
  $question = Question::create('What else can I help you with?')
   ->callbackId('select_time')
   ->addButtons([
    Button::create('Hours')->value('hours'),
    Button::create('Location')->value('location'),
    Button::create('Feedback')->value('feedback'),
    Button::create('Specials')->value('specials'),
    Button::create('Menu')->value('menu'),

   ]);
  $botman->reply($question);
 }

}
