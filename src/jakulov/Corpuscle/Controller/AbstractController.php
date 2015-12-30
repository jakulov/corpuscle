<?php
namespace jakulov\Corpuscle\Controller;

use jakulov\Corpuscle\Core\AppInterface;
use jakulov\Corpuscle\Exception\HttpNotFoundException;
use jakulov\Corpuscle\Router\RouteResult;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractController
 * @package jakulov\Corpuscle\Controller
 */
abstract class AbstractController implements ControllerInterface
{
    /** @var AppInterface */
    protected $app;

    /**
     * @param AppInterface $app
     * @return $this
     */
    public function setApp(AppInterface $app)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * @param RouteResult $route
     * @return Response
     * @throws HttpNotFoundException
     */
    public function run(RouteResult $route) : Response
    {
        $action = $route->action . 'Action';

        if(method_exists($this, $action)) {
            $params = [];
            if($route->id !== null) {
                $params[] = $route->id;
            }

            return call_user_func_array([$this, $action], $params);
        }

        throw new HttpNotFoundException(sprintf(
            'Unknown action: %s in controller %s', $route->action, get_class($this)
        ));
    }

}