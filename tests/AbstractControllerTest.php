<?php

/**
 * Created by PhpStorm.
 * User: yakov
 * Date: 31.12.15
 * Time: 2:02
 */
class AbstractControllerTest extends PHPUnit_Framework_TestCase
{

    public function testRun()
    {
        $app = \jakulov\Corpuscle\Core\App::getInstance([]);
        $request = \Symfony\Component\HttpFoundation\Request::create('/', 'POST');
        $ok = $app->handleHttpRequest($request, false);

        $this->assertEquals(true, $ok instanceof \Symfony\Component\HttpFoundation\Response);
        $this->assertEquals(true, stripos($ok->getContent(), 'Unknown action') !== false);
        $this->assertEquals(404, $ok->getStatusCode());
    }
}
