<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class PowCommand extends Command
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
        $baseVerb = $this->getBaseVerb();
        $expVerb = $this->getExpVerb();

        $this->signature = sprintf(
            '%s {%s : The %s number} {%s : The %s number}',
            $commandVerb,
            $baseVerb,
            $baseVerb,
            $expVerb,
            $this->getExponentVerb()
        );
        $this->description = sprintf('%s the given number', ucfirst($this->getExponentVerb()));
        parent::__construct();
    }

    protected function getCommandVerb(): string
    {
        return 'pow';
    }

    protected function getBaseVerb(): string
    {
        return 'base';
    }

    protected function getExpVerb(): string
    {
        return 'exp';
    }

    protected function getExponentVerb(): string
    {
        return 'exponent';
    }

    public function handle(): void
    {
        $base = $this->getBaseInput();
        $exp = $this->getExpInput();
        $description = $this->generateCalculationDescription($base, $exp);
        $result = $this->calculate($base, $exp);

        $this->comment(sprintf('%s = %s', $description, $result));
    }

    protected function getBaseInput()
    {
        return $this->argument('base');
    }

    protected function getExpInput()
    {
        return $this->argument('exp');
    }

    protected function generateCalculationDescription($base, $exp): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, [$base, $exp]);
    }

    protected function getOperator(): string
    {
        return '^';
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        return $number1 ** $number2;
    }
}
