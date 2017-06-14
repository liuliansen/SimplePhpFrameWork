<?php
namespace includes;

class Request
{
    static private $instance = null;

    private $request = [];

    /**
     * Request constructor.
     * @param $request
     */
    private function __construct($request)
    {
        foreach ($request as $key => $v) {
            $this->request[$key] = $v;
        }
    }

    /**
     * @param $request
     * @return Request
     */
    static public function newInstance($request)
    {
        if(static::$instance == null) {
            static::$instance = new self($request);
        }
        return static::$instance;
    }


    /**
     * @param $key
     * @param bool $getDefault
     * @param null $default
     * @return null
     */
    public function get($key, $getDefault = false , $default = null)
    {
        if($getDefault && !isset($this->request[$key])) {
            return $default;
        }else {
            if(is_string($this->request[$key])) {
                return trim($this->request[$key]);
            }else return $this->request[$key];
        }
    }

}