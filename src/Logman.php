<?php 

namespace Logman;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Logman 
{
    public function index()
    {
        $logger = new Logger('logman');
        $logger->pushHandler(new StreamHandler('logman.log', Logger::DEBUG));
        $logger->info('My logger is now ready');
    }
}