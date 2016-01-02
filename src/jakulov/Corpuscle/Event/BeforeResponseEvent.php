<?php
namespace jakulov\Corpuscle\Event;

use jakulov\Event\AbstractEvent;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BeforeResponseEvent
 * @package jakulov\Corpuscle\Event
 */
class BeforeResponseEvent extends AbstractEvent
{
    /** @var string */
    protected $name = 'app.before_response';
    /** @var Response */
    protected $response;

    /**
     * BeforeResponseEvent constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

}