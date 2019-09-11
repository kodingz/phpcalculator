<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class HistoryClearCommand extends BaseCommand
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
        $this->signature = $this->getCommandVerb();
        $this->description = 'Clear saved history';
        parent::__construct();
    }

    protected function getCommandVerb(): string
    {
        return 'history:clear';
    }

    public function handle(): void
    {
        $this->deleteCsv();
        $this->info('History cleared!');
    }

    protected function deleteCsv()
    {
        $filepath = __DIR__.'/../../history.csv';
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }
}
