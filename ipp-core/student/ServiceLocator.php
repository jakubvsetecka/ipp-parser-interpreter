<?php

namespace IPP\Student;

class ServiceLocator
{
    private $services = [];

    public function register($key, $service)
    {
        $this->services[$key] = $service;
    }

    public function get($key)
    {
        if (!array_key_exists($key, $this->services)) {
            return null;
        }
        return $this->services[$key];
    }
}
