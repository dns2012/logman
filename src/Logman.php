<?php

namespace Logman;

use Exception;
use Logman\App\Consumer\CustomLog;
use Logman\App\Consumer\StandardLog;
use Logman\App\Producer\Format;
use Logman\App\Producer\Stream;
use Logman\DTOs\LogDTO;
use Logman\Interfaces\LogmanInterface;

/**
 * Logman
 *
 * @method static void setup(string $channelName, string $format)
 * @method static void listen()
 * @method static void info(string $message, array $context = [])
 * @method static void warning(string $message, array $context = [])
 * @method static void error(string $message, array $context = [])
 * @method static void critical(string $message, array $context = [])
 *
 * @see Logman
 */
class Logman implements LogmanInterface
{
    /**
     * @var array static $routes
     */
    protected static $routes = [
        'listen'    => StandardLog::class,
        'info'      => CustomLog::class,
        'warning'   => CustomLog::class,
        'error'     => CustomLog::class,
        'critical'  => CustomLog::class,
    ];

    /**
     * @var object static $logDTO
     */
    protected static $logDTO;

    /**
     * @param  string $channelName
     * @param  string $format
     * @return void
     */
    public static function setup($channelName = Stream::DEFAULT_CHANNEL, $format = Format::LINE_FORMAT)
    {
        self::$logDTO = new LogDTO();
        self::$logDTO->setChannel($channelName);
        self::$logDTO->setFormat($format);
    }

    /**
     * @param  string $name
     * @param  array $args
     * @return void
     */
    public static function __callStatic($name, $args)
    {
        if (!array_key_exists($name, self::$routes)) {
            throw new Exception("Route `{$name}` not found!");
        }
        array_unshift($args, self::$logDTO);
        $route = self::$routes[$name];
        $class = new $route(self::$logDTO);
        $class->{'call'}($name, $args);
    }
}
