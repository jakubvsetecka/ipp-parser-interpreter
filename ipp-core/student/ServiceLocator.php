<?php

namespace IPP\Student;

class ServiceLocator
{
    /** @var array<string, mixed> */
    private array $services = [];

    public function register(string $key, mixed $service): void
    {
        $this->services[$key] = $service;
    }

    public function get(string $key): mixed
    {
        if (!array_key_exists($key, $this->services)) {
            return null;
        }
        return $this->services[$key];
    }
}
