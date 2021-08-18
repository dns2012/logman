<?php

namespace Logman\App\Consumer;

use Logman\App\Producer\Format;
use Logman\App\Producer\Recorder;
use Logman\DTOs\LogDTO;

abstract class ConsumerAbstract
{
    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    abstract protected function invoker($methodName, $args);

    /**
     * @param  string $methodName
     * @param  array $args
     * @return void
     */
    abstract public function call($methodName, $args);

    /**
     * @param  string $channel
     * @param  string $format
     * @param  string $level
     * @param  string $message
     * @param  array  $context
     * @return void
     */
    protected function generate($channel, $format, $level, $message, $context)
    {
        $logDTO = new LogDTO();
        $logDTO->setChannel($channel);
        $logDTO->setFormat($format);
        $logDTO->setLevel($level);
        $logDTO->setMessage($message);
        $logDTO->setContext($context);

        $recorder = new Recorder($logDTO);
        $recorder->write();
    }

    /**
     * @param  LogDTO $logDTO
     * @param  string $level
     * @param  string $message
     * @param  string $context
     * @return void
     */
    protected function record($channel, $format, $withJson, $level, $message, $context)
    {
        $this->generate($channel, $format, $level, $message, $context);
        if ($withJson) {
            $this->generate("{$channel}-json", Format::JSON_FORMAT, $level, $message, $context);
        }
    }

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    protected function info(LogDTO $logDTO, $message, $context = [])
    {
        $this->record(
            $logDTO->getChannel(), $logDTO->getFormat(), $logDTO->getWithJson(),
            __FUNCTION__, $message, $context
        );
    }

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    protected function warning(LogDTO $logDTO, $message, $context = [])
    {
        $this->record(
            $logDTO->getChannel(), $logDTO->getFormat(), $logDTO->getWithJson(),
            __FUNCTION__, $message, $context
        );
    }

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    protected function error(LogDTO $logDTO, $message, $context = [])
    {
        $this->record(
            $logDTO->getChannel(), $logDTO->getFormat(), $logDTO->getWithJson(),
            __FUNCTION__, $message, $context
        );
    }

    /**
     * @param  LogDTO $logDTO
     * @param  string $message
     * @param  string $context
     * @return void
     */
    protected function critical(LogDTO $logDTO, $message, $context = [])
    {
        $this->record(
            $logDTO->getChannel(), $logDTO->getFormat(), $logDTO->getWithJson(),
            __FUNCTION__, $message, $context
        );
    }
}
