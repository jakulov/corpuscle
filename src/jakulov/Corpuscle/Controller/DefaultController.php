<?php
namespace jakulov\Corpuscle\Controller;

use jakulov\Corpuscle\Exception\HttpNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package jakulov\Corpuscle\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @return Response
     */
    protected function listAction()
    {
        // TODO: be more friendly
        return new Response('Hello, Corpuscle!');
    }

    /**
     * @param \Exception $exception
     * @return Response
     */
    protected function showAction(\Exception $exception)
    {
        return new Response($exception->getMessage(), $exception instanceof HttpNotFoundException ? 404 : 500);
    }
}