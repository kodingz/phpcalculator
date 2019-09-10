<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class MultiplyCommand extends BaseCommand
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
            '%s {numbers* : The numbers to be %s}',
            $commandVerb,
            $this->getCommandPassiveVerb()
        );
        $this->description = sprintf('%s all given Numbers', ucfirst($commandVerb));
        parent::__construct();
    }

    protected function getCommandVerb(): string
    {
        return 'multiply';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'multiplied';
    }

    protected function getOperator(): string
    {
        return '*';
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        return $number1 * $number2;
    }
}
