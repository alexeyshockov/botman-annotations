<?php

use AlexS\BotMan\Annotations\Hears;
use BotMan\BotMan\BotMan;

class GreetingConversation
{
    /**
     * @Hears("Hey!")
     * @Hears("Hi")
     */
    public function hey(BotMan $bot)
    {
        $bot->reply('Hi! How are you?');
    }

    /**
     * @Hears("What is the day {date}")
     */
    public function day(BotMan $bot, $date)
    {
        $day = ''; // TODO
        $bot->reply("$date is $day");
    }
}
