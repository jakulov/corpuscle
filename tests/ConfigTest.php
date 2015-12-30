<?php


class ConfigTest extends PHPUnit_Framework_TestCase
{

    public function testLoad()
    {
        $config = \jakulov\Corpuscle\Core\Config::load(__DIR__ .'/config', 'test');

        $this->assertEquals('test', $config['app']['env']);
        $this->assertEquals('bar', $config['app']['foo']);
        $this->assertEquals(__DIR__ .'/config/test', $config['app']['dev_test']);

        $app = \jakulov\Corpuscle\Core\App::getInstance($config);


        $this->assertEquals('test', $app->getEnvironment());
    }

    public function testPrepend()
    {
        $config = \jakulov\Corpuscle\Core\Config::load(__DIR__ .'/config', 'test');
        $config = \jakulov\Corpuscle\Core\Config::prependConfig(__DIR__ .'/prepend_config', $config);

        $this->assertEquals('value', $config['app']['test']);
        $this->assertEquals('prepend_value', $config['app']['prepend_test']);
        $this->assertEquals('that_is_ok', $config['prepend']);
    }


}
