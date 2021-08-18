<?php

namespace Logman\Interfaces\App\Producer;

interface StreamInterface
{
    /**
     * @return Logger
     */
    public function channel();

    /**
     * @return StreamHandler
     */
    public function handler();

    /**
     * @return object
     */
    public function build();
}
