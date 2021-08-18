<?php

namespace Logman\DTOs;

use Logman\Interfaces\App\DTOs\LogDTOInterface;

class LogDTO implements LogDTOInterface
{
    /**
     * @var string $channel
     */
    protected $channel;

    /**
     * @var string $level
     */
    protected $level;

    /**
     * @var string $message
     */
    protected $message;

    /**
     * @var array $context
     */
    protected $context = [];

    /**
     * @var string $format
     */
    protected $format;

    /**
     * @param  string $channel
     * @return void
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param  string $level
     * @return void
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param  string $message
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param  array $context
     * @return void
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param  string $format
     * @return void
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
}
