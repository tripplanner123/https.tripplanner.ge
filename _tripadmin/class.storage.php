<?php

defined('DIR') OR exit;

class Storage
{
    protected static $instance;
    protected $storage = array();

    public static function instance()
    {
        NULL === self::$instance AND self::$instance = new self;
        return self::$instance;
    }

    public function set($key, $value)
    {
        $this->storage[$key] = $value;
    }

    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    public function get($key, $default = FALSE)
    {
        return ($this->exists($key)) ? $this->storage[$key] : $default;
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function exists($key)
    {
        return isset($this->storage[$key]);
    }

    public function __isset($key)
    {
        return $this->exists($key);
    }

    public function remove($key)
    {
        if (!$this->exists($key))
            return FALSE;
        unset($this->storage[$key]);
        return TRUE;
    }

    public function __unset($key)
    {
        $this->remove($key);
    }

    private function __construct()
    {

    }

    private function __clone()
    {

    }

}
