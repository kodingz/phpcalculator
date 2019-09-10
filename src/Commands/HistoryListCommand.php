<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class HistoryListCommand extends BaseCommand
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    public function __construct()
    {
        $commandVerb = $this->getCommandVerb();

        $this->signature = sprintf(
            '%s {commands?* : Filter the history by commands}',
            $commandVerb
        );
        $this->description = 'Show calculator history';
        parent::__construct();
    }

    protected function getCommandVerb(): string
    {
        return 'history:list';
    }

    public function handle(): void
    {
        $commands = $this->getInput();
        $headers = [
            'No',
            'Command',
            'Description',
            'Result',
            'Output',
            'Time',
        ];
        $history = $this->getHistory($commands);
        if ($history) {
            $this->table($headers, $history);
        } else {
            $this->info('History is empty.');
        }
    }

    protected function getInput(): array
    {
        return $this->argument('commands');
    }

    protected function getHistory($commands)
    {
        $hash = [];
        foreach ($commands as $command) {
            $hash[strtolower($command)] = true;
        }
        $history = $this->readCsv($hash);

        return $history;
    }

    protected function readCsv($commands)
    {
        $filepath = __DIR__.'/../../history.csv';
        $lines = [];
        $no = 1;
        if (file_exists($filepath)) {
            $fh = fopen($filepath, 'r');
            while (!feof($fh)) {
                $line = trim(fgets($fh));
                if ($line) {
                    $cols = explode(',', $line);
                    if (empty($commands) || ($commands && isset($cols[0]) && isset($commands[strtolower($cols[0])]))) {
                        array_unshift($cols, $no);
                        $lines[] = $cols;
                        $no++;
                    }
                }
            }
            fclose($fh);
        }

        return $lines;
    }
}
