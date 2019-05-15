<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 08/05/2019
 * Time: 03:45 PM
 */

namespace DDIS\lang\app\Traits;

use DDIS\lang\app\Models\Form;
use Illuminate\Support\Facades\Validator;

trait Validation
{
    public function bootValidator()
    {
        Validator::extend('keyExist', function($attribute, $value, $parameters)
        {

            $config=config('DDISlang.'.$parameters[0]);
            if(in_array($attribute,  $config)) return true;
            return false;
        });

        Validator::extend('FormExist',function ($attribute, $value, $parameters){

            $Form = new Form();
            if($Form->find($value)){
                return true;
            }
            return false;
        });

  }

}