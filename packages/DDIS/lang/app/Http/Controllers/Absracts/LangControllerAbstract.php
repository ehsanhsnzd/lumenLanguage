<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 01/05/2019
 * Time: 11:43 AM
 */

namespace DDIS\lang\app\Http\Controllers\Absracts;


use DDIS\lang\app\Http\Controllers\LangBaseController;
use DDIS\lang\app\Repository\Interfaces\RepositoryInterface;
use Illuminate\Http\Request;

abstract class LangControllerAbstract extends LangBaseController
{
    /**
     * return model
     * @var
     */
private $Service;

    /**
     * Return all model with relation
     */
    public function getAll(){}

    /**Return model by id
     * @param $id
     */
    public function get($id){}

    /**
     * return single model by id
     * @param $id
     */
    public function model($id){}

    /**
     * Create new object in model
     * @param Request $request
     */
    public function set(Request $request){}

    /**update model object
     * @param Request $request
     * @param $id
     */
    public function update(Request $request,$id){}

    /**
     * delete object of model
     * @param $id
     */
    public function delete($id){}
}