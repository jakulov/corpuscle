<?php
namespace jakulov\Corpuscle\Event;

/**
 * Class AfterResponseEvent
 * @package jakulov\Corpuscle\Event
 */
class AfterResponseEvent extends BeforeResponseEvent
{
    protected $name = 'app.after_response';
}