<?php

namespace Core\Traits\Making\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MakingCommand
{
    /**
     * Making a Command With Given Information.
     * 
     * @since 1.0.0
     * 
     * @param array $params
     * 
     * @return string
     */
    protected function command(array $params): string
    {
        if (! $params[1])
            return CLI::out('Please Enter A Name For Your Command !', CLI::RED);

        $fileName = ucfirst($params[1]);

        $templatePath = $this->templatePath('Command');
        $originPath = $this->originPath('App', 'Commands', $fileName);

        $content = $this->getContent($templatePath);

        $finalContent = $this->replacePlaceholders($content, $fileName);

        $this->createFile($originPath, $finalContent);

        $fileName = str_ireplace("Command", '', $fileName) .  ' - Command';

        return CLI::out("{$fileName} Created !", CLI::BLUE);
    }
}