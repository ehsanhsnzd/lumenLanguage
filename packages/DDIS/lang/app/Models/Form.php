<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 30/04/2019
 * Time: 03:36 PM
 */
namespace DDIS\lang\app\Models;


use DDIS\lang\app\Models\Mongodb\LangModel;

class Form extends LangModel
{

    protected $Collection ="form";

    protected $primaryKey ="_id";

}