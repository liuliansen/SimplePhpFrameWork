<?php
namespace task;

class Task
{
    protected $args = [];
    public function __construct($args)
    {
        $this->args = $args;
    }
}

