<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 07/05/2019
 * Time: 01:42 PM
 */

namespace DDIS\lang\app\Services;


use DDIS\lang\app\Exceptions\EmptyException;
use DDIS\lang\app\Models\Form;
use DDIS\lang\app\Repository\RepositorySentence;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class SentenceService extends BaseService
{

    private $Repository;

    public function __construct(RepositorySentence $Repository = null)
    {

        $this->Repository = $Repository ?? new RepositorySentence();
    }


    /**
     * @return array
     * @throws \DDIS\lang\app\Exceptions\EmptyException
     */
    public function getAll(): array
    {
        return $this->Repository->getAll();
    }

    /**
     * @param string $id
     * @return Collection
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function get(string $id): Collection
    {
        return $this->Repository->get($id);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws EntryNotFoundException
     */
    public function model(string $id)
    {
        return $this->Repository->model($id);
    }

    /**
     * @param array $params
     * @return Collection
     * @throws ValidationException
     * @throws \DDIS\lang\app\Exceptions\EmptyException
     */
    public function set(array $params): Collection
    {
        $params = $this->validate($params, true);
        return $this->Repository->set($params);
    }

    /**
     * @param array $params
     * @param string $id
     * @return Collection
     * @throws EntryNotFoundException
     * @throws ValidationException
     */
    public function update(array $params, string $id): Collection
    {
        $params = $this->validate($params);
        return $this->Repository->update($params, $id);
    }

    /**
     * @param string $id
     * @return bool
     * @throws EntryNotFoundException
     */
    public function delete(string $id): bool
    {
        return $this->Repository->delete($id);
    }

    /**
     * @param $params
     * @return array
     * @throws ValidationException
     */

    private function validate($params, bool $newObject = False): array
    {


        foreach ($params as $key => $value) {
            $rules[$key] = 'keyExist:input.sentence';
        }
        $rules['form_id'] = 'FormExist';

        unset($rules['translate']);

            if(isset($params['translate']))
        foreach ($params['translate'] as $key => $value) {
            $rules[$key] = 'keyExist:languages';
        }
//            if (!$this->checkTranslate($params["translate"])) {
//                unset($params['translate']);
//                $rules['translate'] = 'required';
//            }
        if ($newObject) {
            $rules['form_id'] = 'required|FormExist';
            $rules['slug'] = 'required';
        }



        $validator = Validator::make($params, $rules);
        if ($validator->fails() ) {
            throw new ValidationException($validator );
        } else {
            return $params;
        }

    }

    public function checkArray(array $array, array $config)
    {
        foreach ($array as $key => $value) {
            if (!in_array($key, $config)) {
                return false;
            }
        }
        return true;
    }

    public function checkTranslate(array $params)
    {
        $result = $this->checkArray($params, config('DDISlang.languages'));
        return $result;
    }

}