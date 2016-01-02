<?php
namespace jakulov\Corpuscle\Core;

use jakulov\Corpuscle\Event\AfterResponseEvent;
use jakulov\Corpuscle\Event\BeforeResponseEvent;
use jakulov\Corpuscle\Event\ErrorEvent;
use jakulov\Corpuscle\Event\RequestEvent;
use jakulov\Corpuscle\Event\RouteEvent;
use jakulov\Corpuscle\Event\ShutdownEvent;
use jakulov\Event\EventDispatcher;
use Interop\Container\ContainerInterface;
use jakulov\Container\DIContainer;
use jakulov\Corpuscle\Controller\ControllerInterface;
use jakulov\Corpuscle\Exception\HttpNotFoundException;
use jakulov\Corpuscle\Router\RouteResult;
use jakulov\Corpuscle\Router\RouterInterface;
use Psr\Event\EventInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use jakulov\Container\Container;

/**
 * Class App
 * @package jakulov\Corpuscle\Core
 */
class App implements AppInterface
{
    /** @var AppInterface */
    protected static $instance;
    /** @var ContainerInterface */
    protected $DIContainer;
    /** @var Request */
    protected $request;
    /** @var string */
    protected static $varDir;

    /**
     * @return string
     */
    public static function getVarDir()
    {
        if(self::$varDir !== null) {
            return self::$varDir;
        }

        throw new \RuntimeException('Unable to access var dir without handle request call');
    }


    /**
     * @param array $config
     * @return AppInterface
     */
    public static function getInstance(array $config = [])
    {
        if(self::$instance === null) {
            self::$instance = new self(Config::prependConfig(__DIR__ .'/../config', $config));
        }

        return self::$instance;
    }

    /**
     * App constructor.
     * @param array $config
     */
    protected function __construct(array $config = [])
    {
        $this->DIContainer = DIContainer::getInstance($config);
    }

    /**
     * @param Request $request
     * @param bool $sendResponse
     * @return Response
     */
    public function handleHttpRequest(Request $request = null, $sendResponse = true) : Response
    {
        try {
            $this->getDIContainer()->provide('request', $request);
            $this->initRuntime($request);
            $route = $this->getRouter()->route($this->request);
            if ($route->isNotFound() === false) {
                $this->onRoute($route);
                return $this->sendResponse($this->runController($route), $sendResponse);
            }

            throw new HttpNotFoundException(sprintf(
                'Unable to match route for: %s', $this->request->getMethod() .' '. $this->request->getPathInfo()
            ));
        }
        catch(\Exception $e) {
            return $this->handleError($e, $sendResponse);
        }
    }

    /**
     * @param RouteResult $route
     */
    protected function onRoute(RouteResult $route)
    {
        $this->dispatchEvent(new RouteEvent($this->request, $route));
    }

    /**
     * @param Request $request
     */
    protected function initRuntime(Request $request)
    {
        $this->request = $request ? $request : Request::createFromGlobals();
        $this->onHttpRequest($request);
        $varDir = $this->getContainer()->get('app.var_dir');
        self::$varDir = $this->request->server->get('DOCUMENT_ROOT', __DIR__) .'/'. $varDir;
    }

    /**
     * @return EventDispatcher
     */
    protected function getEventDispatcher()
    {
        return $this->getDIContainer()->get('event_dispatcher');
    }

    /**
     * @param Request $request
     */
    protected function onHttpRequest(Request $request)
    {
        $this->dispatchEvent(new RequestEvent($request));
    }

    /**
     * @param EventInterface $event
     */
    protected function dispatchEvent(EventInterface $event)
    {
        $this->getEventDispatcher()->dispatch($event->getName(), $event);
    }

    /**
     * @param \Exception $exception
     * @param bool $sendResponse
     * @return Response
     */
    protected function handleError(\Exception $exception, $sendResponse = true) : Response
    {
        $this->dispatchEvent(new ErrorEvent($exception));

        $route = new RouteResult();
        $route->controller = $this->getContainer()->get('router.error');
        $route->action = RouteResult::ACTION_SHOW;
        $route->id = $exception;

        return $this->sendResponse($this->runController($route), $sendResponse);
    }

    /**
     * @param Response $response
     * @param bool $sendResponse
     * @return Response
     */
    protected function sendResponse(Response $response, $sendResponse = true) : Response
    {
        $this->beforeResponse($response);
        $return = $sendResponse ? $response->send() : $response;
        $this->afterResponse($return);

        return $return;
    }

    /**
     * @param Response $response
     */
    protected function beforeResponse(Response $response)
    {
        $this->dispatchEvent(new BeforeResponseEvent($response));
    }

    /**
     * @param Response $response
     */
    protected function afterResponse(Response $response)
    {
        $this->dispatchEvent(new AfterResponseEvent($response));
    }

    /**
     * Shutdown app
     */
    public function shutdown()
    {
        $this->dispatchEvent(new ShutdownEvent());
    }

    /**
     * @param RouteResult $route
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function runController(RouteResult $route) : Response
    {
        if(!class_exists($route->controller)) {
            throw new \RuntimeException(sprintf('Unable to find controller class: %s', $route->controller));
        }

        $controller = new $route->controller;
        if(!$controller instanceof ControllerInterface) {
            throw new \RuntimeException(sprintf(
                'Controller %s should implements %s', $route->controller, ControllerInterface::class
            ));
        }

        return $controller->setApp($this)->run($route);
    }

    /**
     * @return RouterInterface
     */
    protected function getRouter() : RouterInterface
    {
        return $this->getService('service.router');
    }

    /**
     * @return Request
     */
    public function getRequest() : Request
    {
        return $this->request ? $this->request : Request::createFromGlobals();
    }


    /**
     * @param $id
     * @param null $default
     * @return mixed
     */
    public function get($id, $default = null)
    {
        return $this->getContainer()->get($id, $default);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getService($id)
    {
        return $this->DIContainer->get($id);
    }

    /**
     * @return Container
     */
    public function getContainer() : Container
    {
        return $this->DIContainer->get('service.container');
    }

    /**
     * @return DIContainer
     */
    public function getDIContainer() : DIContainer
    {
        return $this->DIContainer;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->getContainer()->get('app.env');
    }

    /**
     * Shutdown app
     */
    function __destruct()
    {
        //$this->shutdown();
    }


}