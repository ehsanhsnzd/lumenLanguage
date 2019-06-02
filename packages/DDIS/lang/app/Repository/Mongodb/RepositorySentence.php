<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 07/05/2019
 * Time: 12:22 PM
 */

namespace DDIS\lang\app\Repository;

use DDIS\lang\app\Exceptions\EmptyException;
use DDIS\lang\app\Models\Form;
use DDIS\lang\app\Models\Sentence;
use DDIS\lang\app\Repository\Interfaces\RepositoryInterface;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Support\Collection;

class RepositorySentence implements RepositoryInterface
{


    /**
     * @return array
     * @throws EmptyException
     */
    public function getAll(): array
    {
        $sentence = new Sentence;
        if ($sentence->count()) {
            $object = Sentence::paginate(config('DDISlang.paginateQTY'));
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

            $object = Sentence::where('form_id', $id)->paginate(config('DDISlang.paginateQTY'));
        if (Form::find($id) && $object->count()) {
            if ($object) {
                return collect($object);
            }
        }
            throw new EntryNotFoundException("Object not found");

    }


    /**
     * @param string $id
     * @return Collection
     * @throws EntryNotFoundException
     */
    public function getBySlug(string $id): Collection
    {

            $object = Sentence::where('slug', $id)->get();
        if ($object->count()) {
            if ($object) {
                return collect($object);
            }
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
            $object = Sentence::find($id);
            if ($object) {
                return $object;
            }
            throw new EntryNotFoundException("Model not found");
    }

    /**
     * @param array $params
     * @return Collection
     * @throws EmptyException
     */
    public function set(array $params): Collection
    {

            $object = new Sentence();

            foreach ($params as $key => $value) {
                $object->$key = $value;
            }
            $object->save();

            if ($object) {
                return collect($object);
            }


        throw new EmptyException("Wrong data");
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
            if(isset($params['translate']))
            foreach ($params['translate'] as $key => $value) {
                Sentence::where('_id', $id)->update(array("translate.$key" => $value));
                unset($params['translate']);
            }


                foreach ($params as $key => $value) {
                    $object->$key = $value;
                }

             $object->save();

            if ($object) {
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
