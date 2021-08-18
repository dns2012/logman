<?php

namespace Logman\Interfaces\App\Consumer;

use Logman\DTOs\LogDTO;

interface StandardLogInterface
{
    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    public function call($methodName, $args);

    /**
     * @return void
     */
    public function errorHandler();
}
