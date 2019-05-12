<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 01/05/2019
 * Time: 03:47 PM
 */

namespace DDIS\lang\app\Exceptions;

use DDIS\lang\app\Exeptions\Interfaces\EmptyExceptionInterface;
use Exception;

class EmptyException extends Exception implements EmptyExceptionInterface
{


    public function __construct($EmptyData = "Empty Data")
    {
        $this->message = $EmptyData;
    }
}