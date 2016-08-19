<?php

namespace NFePHP\Common\Exception;

/**
 * @category   NFePHP
 * @package    NFePHP\Common\Exception
 * @copyright  Copyright (c) 2008-2014
 * @license    http://www.gnu.org/licenses/lesser.html LGPL v3
 * @author     Roberto L. Machado <linux.rlm at gmail dot com>
 * @link       http://github.com/nfephp-org/nfephp for the canonical source repository
 */
class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
    public static function notEmpty($text)
    {
        return new static("The $text must not be empty");
    }

    public static function isNotValidCnpj($cnpj)
    {
        return new static("The CNPJ($cnpj) is not valid");
    }
}
