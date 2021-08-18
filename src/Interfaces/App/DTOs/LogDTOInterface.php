<?php

namespace Logman\Interfaces\App\DTOs;

interface LogDTOInterface
{
    /**
     * @param  string $channel
     * @return void
     */
    public function setChannel($channel);

    /**
     * @return string
     */
    public function getChannel();

    /**
     * @param  string $level
     * @return void
     */
    public function setLevel($level);

    /**
     * @return string
     */
    public function getLevel();

    /**
     * @param  string $message
     * @return void
     */
    public function setMessage($message);

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @param  array $context
     * @return void
     */
    public function setContext($context);

    /**
     * @return array
     */
    public function getContext();

    /**
     * @param  string $format
     * @return void
     */
    public function setFormat($format);

    /**
     * @return string
     */
    public function getFormat();
}
