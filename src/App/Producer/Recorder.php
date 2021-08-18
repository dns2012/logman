<?php

namespace Logman\App\Producer;

class Recorder extends Stream
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
