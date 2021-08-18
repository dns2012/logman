<?php

namespace Logman\App\Producer;

use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\LineFormatter;

class Format extends Stream
{
    /**
     * @var string LINE_FORMAT
     */
    const LINE_FORMAT   = 'line';

    /**
     * @var string JSON_FORMAT
     */
    const JSON_FORMAT   = 'json';

    /**
     * @return LineFormatter
     */
    public function lineFormat()
    {
        $lineFormat = "%datetime% | LEVEL : %channel%.%level_name% | MESSAGE : %message% | PARAMS : %context%\n";
        $dateFormat = "[Y-m-d H:i:s]";
        return new LineFormatter($lineFormat, $dateFormat);
    }

    /**
     * @return JsonFormatter
     */
    public function jsonFormat()
    {
        return new JsonFormatter();
    }

    /**
     * @return LineFormatter|JsonFormatter
     */
    public function getFormat()
    {
        switch ($this->logDTO->getFormat()) {
            case self::LINE_FORMAT:
                return $this->lineFormat();
                break;
            case self::JSON_FORMAT:
                return $this->jsonFormat();
            default:
                $this->lineFormat();
                break;
        }
    }
}
