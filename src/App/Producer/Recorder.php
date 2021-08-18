<?php

namespace Logman\App\Producer;

use Logman\Interfaces\App\Producer\RecorderInterface;
use Logman\Interfaces\App\Producer\StreamInterface;

class Recorder extends Stream implements StreamInterface, RecorderInterface
{
    /**
     * @return void
     */
    public function write()
    {
        $this->format();
        $this->build()->{$this->logDTO->getLevel()}(
            $this->logDTO->getMessage(),
            $this->logDTO->getContext()
        );
    }

    /**
     * @return void
     */
    private function format()
    {
        $format = new Format($this->logDTO);
        $this->format = $format->getFormat();
    }
}
