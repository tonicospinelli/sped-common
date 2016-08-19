<?php

namespace NFePHP\Common\Tests\Document\Cnpj;

use NFePHP\Common\Document\Cnpj;
use NFePHP\Common\Document\Modulus11;
use NFePHP\Common\Exception\InvalidArgumentException;

class Modulus11Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $number
     * @dataProvider provideValidNumbers
     */
    public function testShouldGetSuccessOnValidateNumbers($number)
    {
        $modulus = new Modulus11(2, 9);
        $this->assertTrue($modulus->validate($number));
    }

    public function provideValidNumbers()
    {
        return [
            ['48464245000104'],
            ['48.464.245/0001-04'],
            //['007007013X'],
        ];
    }
}
