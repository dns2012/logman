<?php

namespace Logman\App\Consumer;

use Exception;
use Logman\App\Producer\Format;
use Logman\App\Producer\Recorder;
use Logman\DTOs\LogDTO;
use Logman\Interfaces\App\Consumer\CustomLogInterface;

class CustomLog implements CustomLogInterface
{
    /**
     * @param  LogDTO $logDTO
     * @param  string $level
     * @param  string $message
     * @param  string $context
     * @return void
     */
    private function record(LogDTO $logDTO, $level, $message, $context)
    {
        $channel = $logDTO->getChannel();
        $format  = $logDTO->getFormat();

        $logDTO->setLevel($level);
        $logDTO->setMessage($message);
        $logDTO->setContext($context);
        $record = new Recorder($logDTO);
        $record->write();

        if ($format == Format::LINE_FORMAT) {
            $logDTO->setChannel("{$channel}-json");
            $logDTO->setFormat(Format::JSON_FORMAT);
            $record->write();

            $logDTO->setChannel($channel);
            $logDTO->setFormat($format);
        }
    }

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    public function info(LogDTO $logDTO, $message, $context)
    {
        $this->record($logDTO, __FUNCTION__, $message, $context);
    }

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    public function warning(LogDTO $logDTO, $message, $context)
    {
        $this->record($logDTO, __FUNCTION__, $message, $context);
    }

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    public function error(LogDTO $logDTO, $message, $context)
    {
        $this->record($logDTO, __FUNCTION__, $message, $context);
    }

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    public function critical(LogDTO $logDTO, $message, $context)
    {
        $this->record($logDTO, __FUNCTION__, $message, $context);
    }

    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    private function patcher($methodName, $args)
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
        $this->patcher($methodName, $args);
    }
}
