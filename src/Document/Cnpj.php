<?php

namespace NFePHP\Common\Document;

use NFePHP\Common\Exception\InvalidArgumentException;

class Cnpj
{
    const REGEX = '/^([\d]{2,3})([\d]{3})([\d]{3})([\d]{4})([\d]{2})$/';

    const FORMAT_REGEX = '/^[\d]{2,3}\.[\d]{3}\.[\d]{3}\/[\d]{4}-[\d]{2}$/';

    /**
     * @var string
     */
    public $cnpj;

    /**
     * Cnpj constructor.
     * @param string $cnpj
     */
    public function __construct($cnpj)
    {
        $this->validate($cnpj);
        $this->cnpj = $cnpj;
    }

    /**
     * Check if CNPJ is not empty and is a valid number.
     * @param string $cnpj
     * @throws InvalidArgumentException when CNPJ is empty
     * @throws InvalidArgumentException when CNPJ is not valid number
     */
    private function validate($cnpj)
    {
        if (empty($cnpj)) {
            throw InvalidArgumentException::notEmpty('cnpj');
        }
        if (!$this->isValidCV($cnpj)) {
            throw InvalidArgumentException::isNotValidCnpj($cnpj);
        }
    }

    /**
     * Validates cnpj is a valid number.
     * @param string $cnpj A number to be validate.
     * @return bool Returns true if it is a valid number, otherwise false.
     */
    private function isValidCV($cnpj): bool
    {
        return (new Modulus11(2, 9))->validate($cnpj);
    }

    /**
     * Formats CNPJ number
     * @return string Returns formatted number, such as: 00.000.000/0000-00
     */
    public function format(): string
    {
        return preg_replace(static::REGEX, '$1.$2.$3/$4-$5', $this->cnpj);
    }
}
