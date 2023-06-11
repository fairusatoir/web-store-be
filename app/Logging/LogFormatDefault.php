<?php

namespace App\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

class LogFormatDefault
{
    /**
     * Customize the given logger instance.
     */
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                "[%datetime%] [%channel%].[%level_name%]: %message% [%context%] [%extra%]\n",
                null,
                true,
                false,
                true,
            ));
        }
    }
}
