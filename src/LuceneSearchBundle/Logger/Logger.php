<?php

namespace LuceneSearchBundle\Logger;

use LuceneSearchBundle\Configuration\Configuration;

class Logger extends AbstractLogger
{
    /**
     * @var bool
     */
    var $backendLog = TRUE;

    /**
     * @param      $message
     * @param      $level
     * @param bool $logToBackend
     * @param bool $logToSystem
     *
     * @return void
     */
    public function log($message, $level = 'debug', $logToBackend = TRUE, $logToSystem = TRUE)
    {
        if ($logToSystem === TRUE) {
            \Pimcore\Logger::log($this->getSystemPrefix() . $this->getPrefix() . $message, $this->getRealLevel($level));
        }

        if ($logToBackend === TRUE) {
            $file = Configuration::CRAWLER_LOG_FILE_PATH;
            $log = date('d.m.Y H:i') . '|' . $this->getRealLevel($level) . '|' . $message . "\n";
            file_put_contents($file, $log, FILE_APPEND);
        }
    }

    /**
     * @param $level
     *
     * @return string
     */
    private function getRealLevel($level)
    {
        if ($level === 'debugHighlight') {
            return 'debug';
        }

        return $level;
    }

    /**
     * @return string
     */
    private function getSystemPrefix()
    {
        return 'LuceneSearch: ';
    }
}