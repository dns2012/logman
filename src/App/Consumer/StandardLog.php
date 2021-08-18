<?php

namespace Logman\App\Consumer;

use Logman\DTOs\LogDTO;
use Psr\Log\LogLevel;

class StandardLog extends ConsumerAbstract
{
    /**
     * @var LogDTO $logDTO
     */
    protected $logDTO;

    /**
     * @param  LogDTO $logDTO
     * @return void
     */
    public function __construct(LogDTO $logDTO)
    {
        $this->logDTO = $logDTO;

        register_shutdown_function(array($this, 'errorHandler'));
        ini_set('display_errors', false);
        ini_set('log_errors', TRUE);
        ini_set('error_reporting', E_ALL);
    }

    /**
     * @return void
     */
    public function errorHandler()
    {
        $lastError = error_get_last();
        if (! empty($lastError)) {
            switch ($lastError['type']) {
                case E_CORE_ERROR:
                case E_CORE_WARNING:
                case E_COMPILE_ERROR:
                case E_COMPILE_WARNING:
                    $errorLevel = LogLevel::CRITICAL;
                    break;
                case E_ERROR:
                case E_PARSE:
                case E_USER_ERROR:
                case E_RECOVERABLE_ERROR:
                    $errorLevel = LogLevel::ERROR;
                    break;
                case E_WARNING:
                case E_NOTICE:
                case E_USER_WARNING:
                case E_USER_NOTICE:
                    $errorLevel = LogLevel::WARNING;
                    break;
                case E_DEPRECATED:
                case E_USER_DEPRECATED:
                    $errorLevel = LogLevel::INFO;
                    break;
                default:
                    $errorLevel = LogLevel::ERROR;
                    break;
            }
            $message = preg_replace('/\r|\n/', '', $lastError['message']) . " | FILE : " . $lastError['file'] . " | LINE : " . $lastError['line'];
            $this->invoker($errorLevel, [$this->logDTO, $message]);
        }
    }

    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    protected function invoker($methodName = NULL, $args = []){
        $this->{$methodName}($args[0], $args[1]);
    }

    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    public function call($methodName = NULL, $args = NULL){}
}
