<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 07/05/2019
 * Time: 12:27 PM
 */

namespace DDIS\lang\app\Models;


use DDIS\lang\app\Models\Mongodb\LangModel;

class Sentence extends LangModel
{
    protected $Collection = 'sentence';

    protected $primaryKey = '_id';

}