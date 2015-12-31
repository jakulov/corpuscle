<?php
namespace jakulov\Corpuscle\Core;

use Interop\Container\ContainerInterface;
use jakulov\Container\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface AppInterface
 * @package jakulov\Corpuscle\Core
 */
interface AppInterface
{
    const ENVIRONMENT_DEV = 'dev';
    const ENVIRONMENT_PROD = 'prod';

    /**
     * AppInterface constructor.
     * @param array $config
     * @return $this
     */
    public static function getInstance(array $config = []);

    /**
     * @param Request|null $request
     * @param bool $sendResponse
     * @return Response
     */
    public function handleHttpRequest(Request $request = null, $sendResponse = true) : Response;

    /**
     * @return Request
     */
    public function getRequest() : Request;

    /**
     * @param $id
     * @param null $default
     * @return mixed
     */
    public function get($id, $default = null);

    /**
     * @param $id
     * @return mixed
     */
    public function getService($id);

    /**
     * @return Container
     */
    public function getContainer() : Container;

    /**
     * @return ContainerInterface
     */
    public function getDIContainer() : ContainerInterface;

    /**
     * @return string
     */
    public function getEnvironment();

    /**
     * @return string
     */
    public static function getVarDir();
}