<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 07/05/2019
 * Time: 01:16 PM
 */

namespace DDIS\lang\app\Http\Controllers\Interfaces;


use DDIS\lang\app\Services\BaseService;

interface ControllerInterface
{
    public function __construct(BaseService $service);

    public function getAll();

    public function get($id);

    public function model($id);

    public function set(Request $request);

    public function update(Request $request,$id);

    public function delete($id);

}