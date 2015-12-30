<?php
namespace jakulov\Corpuscle\Controller;

use jakulov\Corpuscle\Core\AppInterface;
use jakulov\Corpuscle\Router\RouteResult;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ControllerInterface
 * @package jakulov\Corpuscle\Controller
 */
interface ControllerInterface
{
    /**
     * @param AppInterface $app
     * @return $this
     */
    public function setApp(AppInterface $app);

    /**
     * @param RouteResult $route
     * @return Response
     */
    public function run(RouteResult $route) : Response;
}