<?php
namespace jakulov\Corpuscle\Event;

use jakulov\Event\AbstractEvent;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HttpRequestEvent
 * @package jakulov\Corpuscle\Event
 */
class RequestEvent extends AbstractEvent
{
    /** @var string */
    protected $name = 'app.request';
    /** @var Request */
    protected $request;

    /**
     * HttpRequestEvent constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}