<?php

namespace NFePHP\Common\Document;

final class Modulus11
{
    /**
     * Number of check digits.
     * @var int
     */
    protected $digitsCount;

    /**
     * Multiplier limit.
     * @var int
     */
    protected $maxMultiplier;

    /**
     * @var bool
     */
    private $convertX;

    /**
     * Modulus11 constructor.
     * @param int $numberOfDigits
     * @param int $multiplierLimit
     * @param bool $convertX
     */
    public function __construct($numberOfDigits, $multiplierLimit, $convertX = true)
    {
        assert(is_int($numberOfDigits), 'Number of digits must be integer');
        assert(is_int($multiplierLimit), 'Number of digits must be integer');
        $this->digitsCount = (int) $numberOfDigits;
        $this->maxMultiplier = (int) $multiplierLimit;
        $this->convertX = $convertX;
    }

    /**
     * Validação genérica de vários tipos de números. Dentre eles: CPF, CNPJ, PIS.
     * @param string $value Valor a ser validado.
     * @return boolean
     */
    public function validate($number)
    {
        $number = preg_replace('/[^\dX]/i', '', $number);
        $baseNumber = substr($number, 0, (-1 * $this->digitsCount));
        $checkDigits = $this->checkDigits($baseNumber);
        $digits = substr($number, (-1 * $this->digitsCount));
        return ($digits === $checkDigits);
    }

    private function checkDigits($number)
    {
        $numberOfIterations = $this->digitsCount;
        while (--$numberOfIterations >= 0) {
            $digit = $this->calculateDigit($number);
            $number .= $digit;
        }
        return substr($number, (-1 * $this->digitsCount));
    }

    protected function calculate($number)
    {
        $coefficient = 2;
        $digits = str_split(strrev($number));

        $sum = 0;
        foreach ($digits as $digit) {
            $sum += ($coefficient * intval($digit));
            if (++$coefficient > $this->maxMultiplier) {
                $coefficient = 2;
            }
        }

        return $sum;
    }

    private function calculateDigit($number)
    {
        $sum = $this->calculate($number);

        if ($this->convertX) {
            return (($sum * 10) % 11) % 10;
        }

        $digit = $sum % 11;
        if ($digit == 10) {
            $digit = "X";
        }
        return $digit;
    }
}