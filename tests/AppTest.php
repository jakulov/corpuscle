<?php

/**
 * Created by PhpStorm.
 * User: yakov
 * Date: 13.12.15
 * Time: 2:26
 */
class AppTest extends PHPUnit_Framework_TestCase
{

    public function testRun()
    {
        $app = \jakulov\Corpuscle\Core\App::getInstance([]);
        $request = \Symfony\Component\HttpFoundation\Request::create('/', 'GET');
        $ok = $app->handleHttpRequest($request, false);

        $this->assertEquals(true, $ok instanceof \Symfony\Component\HttpFoundation\Response);
        $this->assertEquals(true, stripos($ok->getContent(), 'Hello, Corpuscle!') !== false);
    }

    public function testHandleError()
    {
        $app = \jakulov\Corpuscle\Core\App::getInstance([]);
        $request = \Symfony\Component\HttpFoundation\Request::create('/404', 'GET');
        $ok = $app->handleHttpRequest($request, false);

        $this->assertEquals(true, $ok instanceof \Symfony\Component\HttpFoundation\Response);
        $this->assertEquals(true, stripos($ok->getContent(), 'Unable to match') !== false);
    }

    public function testGetContainer()
    {
        $app = \jakulov\Corpuscle\Core\App::getInstance(['app' => 'test']);
        $test = $app->get('app');

        $this->assertEquals('test', $test);

        $this->assertEquals(\jakulov\Container\Container::getInstance()->get('app'), 'test');
    }

    public function testGetDIContainer()
    {
        require __DIR__ .'/TestService.php';

        $app = \jakulov\Corpuscle\Core\App::getInstance(['app' => 'test', 'service' => [
            'test' => [
                'class' => 'TestService',
                'args' => [':app']
            ]
        ]]);

        /** @var \TestService $service */
        $service = $app->getService('service.test');

        $this->assertEquals($service->test, 'test');
    }


}
