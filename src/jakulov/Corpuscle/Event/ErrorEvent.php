<?php
namespace jakulov\Corpuscle\Event;

use jakulov\Event\AbstractEvent;

/**
 * Class ErrorEvent
 * @package jakulov\Corpuscle\Event
 */
class ErrorEvent extends AbstractEvent
{
    protected $name = 'app.error';
    /** @var \Exception */
    protected $exception;

    /**
     * ErrorEvent constructor.
     * @param \Exception $exception
     */
    public function __construct(\Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

}