<?php

namespace AlexS\BotMan\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class Hears
{
    /**
     * A phrase to hear, like $bot->hears(...)
     *
     * @Required()
     *
     * @var string
     */
    public $value;

    /**
     * Channel type to listen to (either direct message or public channel)
     *
     * @var string
     */
    public $in;
}
