<?php

namespace Logman\Interfaces;

interface LogmanInterface
{
    /**
     * @param  string $channelName
     * @param  string $format
     * @return void
     */
    public static function setup($channelName, $format);
}
