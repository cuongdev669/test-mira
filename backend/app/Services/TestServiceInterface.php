<?php

namespace App\Services;

interface TestServiceInterface
{
    /**
     * Say hello
     *
     * @param string $name
     * @return string
     */
    public function hello(string $name): string;
}
