<?php
namespace jakulov\Corpuscle\Event;

use jakulov\Event\AbstractEvent;

/**
 * Class ShutdownEvent
 * @package jakulov\Corpuscle\Event
 */
class ShutdownEvent extends AbstractEvent
{
    protected $name = 'app.shutdown';
}