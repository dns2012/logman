<?php

namespace Logman\App\Consumer;

use Exception;
use Logman\DTOs\LogDTO;

class CustomLog extends ConsumerAbstract
{

    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    protected function invoker($methodName = NULL, $args = [])
    {
        if (empty($methodName) || count($args) < 2) {
            throw new Exception("Invalid method name or arguments length for method `{$methodName}`!");
        }
        if (! $args[0] instanceof LogDTO) {
            throw new Exception("Invalid arguments offset 0 not instance off LogDTO::class!");
        }
        if (! array_key_exists(2, $args)) {
            $args[2] = [];
        }
        $this->{$methodName}($args[0], $args[1], $args[2]);
    }

    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    public function call($methodName = NULL, $args = []) {
        $this->invoker($methodName, $args);
    }
}
