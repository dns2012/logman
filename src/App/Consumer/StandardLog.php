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

        register_shutdown_function([$this, 'fatalErrorHandler']);
        set_error_handler([$this, 'errorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
        ini_set('display_errors', false);
        ini_set('log_errors', TRUE);
        ini_set('error_reporting', E_ALL);
    }

    /**
     * @return void
     */
    public function fatalErrorHandler()
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
                    $errorLevel = LogLevel::ERROR;
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
     * @param  int $errorLevel
     * @param  string $errorMessage
     * @param  string $errorFile
     * @param  int $errorLine
     * @return boolean
     */
    public function errorHandler($errorLevel, $errorMessage, $errorFile, $errorLine)
    {
        if (! (error_reporting() & $errorLevel)) {
            return false;
        }

        switch ($errorLevel) {
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                $errorLevel = LogLevel::ERROR;
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

        $message = preg_replace('/\r|\n/', '', $errorMessage) . " | FILE : " . $errorFile . " | LINE : " . $errorLine;
        $this->invoker($errorLevel, [$this->logDTO, $message]);
        return true;
    }

    /**
     * @param  object $exception
     * @return void
     */
    public function exceptionHandler($exception)
    {
        $message = preg_replace('/\r|\n/', '', $exception->getMessage()) . " | FILE : " . $exception->getFile() . " | LINE : " . $exception->getLine();
        $this->invoker(LogLevel::ERROR, [$this->logDTO, $message, ['type' => 'Throw Exception']]);
    }

    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    protected function invoker($methodName = NULL, $args = [])
    {
        $context = isset($args[2]) ? $args[2] : [];
        $this->{$methodName}($args[0], $args[1], $context);
    }

    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    public function call($methodName = NULL, $args = NULL){}
}
