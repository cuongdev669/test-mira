<?php
namespace App\Services;


class TestService implements TestServiceInterface
{
    /**
     * Say hello
     *
     * @param string $name
     * @return string
     */
    public function hello(string $name): string
    {
        return 'Hello ' . $name;
    }
}
