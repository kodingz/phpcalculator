<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $numbers = $this->getInput();
        $description = $this->generateCalculationDescription($numbers);
        $result = $this->calculateAll($numbers);

        $output = sprintf('%s = %s', $description, $result);
        $this->writeCsv([ucfirst($this->getCommandVerb()), $description, $result, $output]);
        $this->comment($output);
    }

    protected function getInput(): array
    {
        return $this->argument('numbers');
    }

    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function calculateAll(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateAll($numbers), $number);
    }

    public function writeCsv($cols)
    {
        $content = implode(',', $cols).','.date('Y-m-d H:i:s')."\n";
        $filepath = __DIR__.'/../../history.csv';
        $fh = fopen($filepath, 'a');
        fwrite($fh, $content);
        fclose($fh);
    }
}
