<?php

namespace Logman\Interfaces\App\Producer;

interface FormatInterface
{
    /**
     * @return void
     */
    public function lineFormat();

    /**
     * @return void
     */
    public function jsonFormat();

    /**
     * @return void
     */
    public function getFormat();
}
