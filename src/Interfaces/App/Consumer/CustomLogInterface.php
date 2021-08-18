<?php

namespace Logman\Interfaces\App\Consumer;

use Logman\DTOs\LogDTO;

interface CustomLogInterface
{
    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    public function call($methodName, $args);

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    public function info(LogDTO $logDTO, $message, $context);

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    public function warning(LogDTO $logDTO, $message, $context);

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    public function error(LogDTO $logDTO, $message, $context);

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    public function critical(LogDTO $logDTO, $message, $context);
}
