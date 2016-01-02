<?php
namespace jakulov\Corpuscle\Event;

use jakulov\Corpuscle\Router\RouteResult;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RouteEvent
 * @package jakulov\Corpuscle\Event
 */
class RouteEvent extends RequestEvent
{
    /** @var string */
    protected $name = 'app.route';
    /** @var RouteResult */
    protected $route;

    /**
     * RouteEvent constructor.
     * @param Request $request
     * @param RouteResult $routeShu
     */
    public function __construct(Request $request, RouteResult $route)
    {
        parent::__construct($request);

        $this->route = $route;
    }

    /**
     * @return RouteResult
     */
    public function getRoute()
    {
        return $this->route;
    }

}