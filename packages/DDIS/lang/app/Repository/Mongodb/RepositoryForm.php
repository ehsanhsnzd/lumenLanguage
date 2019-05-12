<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 01/05/2019
 * Time: 01:47 PM
 */

namespace DDIS\lang\app\Repository\Mongodb;


use DDIS\lang\app\Exceptions\EmptyException;
use DDIS\lang\app\Models\Form;
use DDIS\lang\app\Repository\Interfaces\RepositoryFormInterface;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Support\Collection;

class RepositoryForm implements RepositoryFormInterface
{


    /**
     * @return array
     * @throws EmptyException
     */
    public function getAll(): array
    {
        if (Form::count()) {
            $object = Form::paginate(config('DDISlang.paginateQTY'));
            return $object->toArray();
        }

        throw new EmptyException("Empty Data");
    }

    /**
     * @param string $id
     * @return Collection
     * @throws EntryNotFoundException
     */
    public function get(string $id): Collection
    {
        $object = Form::find($id);
        if ($object) {
            return collect($object);
        }
        throw new EntryNotFoundException("Object not found");
    }

    /**
     * @param string $id
     * @return mixed
     * @throws EntryNotFoundException
     */
    public function model(string $id)
    {
        $object = Form::find($id);
        if ($object) {
            return $object;
        }
        throw new EntryNotFoundException("Object not found");
    }

    /**
     * @param array $params
     * @return Collection
     * @throws EmptyException
     */
    public function set(array $params): Collection
    {

        $object = new Form();
        foreach ($params as $key => $value){
            $object->$key=$value;
        }
        $object->save();

        if($object) {
            return collect($object);
        }
        throw new EmptyException("Empty Data");
    }

    /**
     * @param array $params
     * @param string $id
     * @return Collection
     * @throws EntryNotFoundException
     */
    public function update(array $params, string $id): Collection
    {
        $object = $this->model($id);
        foreach ($params as $key => $value){
            $object->$key=$value;
        }
        $object->save();
        if($object) {
            return collect($object);
        }
        throw new EntryNotFoundException("Object not found");
    }

    /**
     * @param string $id
     * @return bool
     * @throws EntryNotFoundException
     */
    public function delete(string $id): bool
    {
        $object = $this->model($id);
        if($object) {
            return $object->delete();
        }
        throw new EntryNotFoundException("Object not found");
    }
}