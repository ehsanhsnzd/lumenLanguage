<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 01/05/2019
 * Time: 04:17 PM
 */

namespace DDIS\lang\app\Services;


use DDIS\lang\app\Repository\Mongodb\RepositoryForm;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FormService extends BaseService
{
    private $Repository;

    /**
     * Return repository
     * FormService constructor.
     * @param RepositoryForm|null $Repository
     */
    public function __construct(RepositoryForm $Repository = null)
    {

        $this->Repository = $Repository ?? new RepositoryForm();
    }

    /**
     * Get all objects service
     * @return array
     * @throws \DDIS\lang\app\Exceptions\EmptyException
     */

    public function getAll():array
    {
      return  $this->Repository->getAll();
    }

    /**
     * @param $id
     * @return Collection
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function get($id):Collection
    {
        return $this->Repository->get($id);
    }

    /**
     * @param $id
     * @return Collection
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function model($id):Collection
    {
        return $this->Repository->model($id);
    }

    /**
     * @param $params
     * @return Collection
     * @throws ValidationException
     * @throws \DDIS\lang\app\Exceptions\EmptyException
     */
    public function set($params):Collection
    {

        $params=$this->validate($params);
        return $this->Repository->set($params);
    }

    /**
     * update in repository
     * @param $params
     * @param $id
     * @return Collection
     * @throws ValidationException
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function update($params,$id):Collection
    {
        $params=$this->validate($params);
        return $this->Repository->update($params,$id);
    }

    /**
     * @param $id
     * @return bool
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function delete($id):bool
    {
        return $this->Repository->delete($id);
    }

    /**
     * @param array $params
     * @return array
     * @throws ValidationException
     */
    private function validate( $params): array
    {
        $rules = [
            'title' => 'required'
        ];

        $validator = Validator::make($params, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        } else {
            return $params;
        }
    }

    public function toArr($object)
    {
        $arrays=array();
        foreach($object as $key=>$value)
        {
            $arrays= Arr::add($arrays, $key,$value );
        }
        return $arrays;
    }
}