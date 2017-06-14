<?php
namespace includes;

class Config
{
    static private $instance = null;

    private function __construct($config)
    {
        foreach ($config as $k => $conf) {
            $this->$k = $conf;
        }
    }

    /**
     * @param $config
     * @return Config
     */
    static public function newInstance($config)
    {
        if(static::$instance == null) {
            static::$instance = new self($config);
        }
        return static::$instance;
    }


}