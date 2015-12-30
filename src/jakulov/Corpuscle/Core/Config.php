<?php
namespace jakulov\Corpuscle\Core;

/**
 * Class Config
 * @package jakulov\Corpuscle\Core
 */
class Config
{
    /**
     * @param string|array $dir
     * @param string $environment
     * @return array
     */
    public static function load($dir, $environment = AppInterface::ENVIRONMENT_DEV) : array
    {
        if(is_array($dir)) {
            $config = [];
            foreach($dir as $d) {
                $config = array_replace_recursive($config, self::load($d, $environment));
            }

            return $config;
        }

        if(!is_dir($dir) || !is_readable($dir)) {
            throw new \InvalidArgumentException('"%s" is not a directory');
        }

        $config = self::loadConfigDir($dir);
        $envDir = $dir .'/'. $environment;
        if(is_dir($envDir) && is_readable($envDir)) {
            $config = array_replace_recursive($config, self::loadConfigDir($envDir));
        }

        if(isset($config['app'])) {
            $config['app']['env'] = $environment;
        }
        else {
            $config['app'] = ['env' => $environment];
        }

        return $config;
    }

    /**
     * @param string|array $dir
     * @param array $config
     * @return array
     */
    public static function prependConfig($dir, array $config) : array
    {
        $env = isset($config['app']) && isset($config['app']['env']) ?
            $config['app']['env'] : AppInterface::ENVIRONMENT_DEV;

        $prependConfig = self::load($dir, $env);
        $prependConfig = array_replace_recursive($prependConfig, $config);

        return array_replace_recursive($config, $prependConfig);
    }

    /**
     * @param $dir
     * @return array
     */
    protected static function loadConfigDir($dir) : array
    {
        $config = [];
        $dh = opendir($dir);
        while($f = readdir($dh)) {
            $file = $dir .'/'. $f;
            if(is_file($file) && is_readable($file)) {
                $c = require $file;
                if(is_array($c)) {
                    $config = array_replace_recursive($config, $c);
                }
            }
        }
        closedir($dh);

        return $config;
    }
}