<?php

namespace Logman\App\Producer;

use Logman\DTOs\LogDTO;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Stream
{
    /**
     * @var LogDTO $logDTO
     */
    protected $logDTO;

    /**
     * @var FormatterInterface $format
     */
    protected $format;

    /**
     * @var string DEFAULT_CHANNEL
     */
    const DEFAULT_CHANNEL = 'logman';

    /**
     * @param  LogDTO $DTO
     * @return void
     */
    public function __construct(LogDTO $DTO)
    {
        $this->logDTO = $DTO;
    }

    /**
     * @return Logger
     */
    public function channel()
    {
        return new Logger($this->logDTO->getChannel());
    }

    /**
     * @return StreamHandler
     */
    public function handler()
    {
        return new StreamHandler("logman/{$this->logDTO->getChannel()}.log", Logger::INFO);
    }

    /**
     * @return object
     */
    public function build()
    {
        $channel = $this->logDTO->getChannel();
        return $this->channel($channel)
            ->pushHandler(
                $this->handler($channel)->setFormatter($this->format)
            );
    }
}
