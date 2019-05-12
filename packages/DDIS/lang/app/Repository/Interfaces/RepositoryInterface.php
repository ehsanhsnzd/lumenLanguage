<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 01/05/2019
 * Time: 12:11 PM
 */

namespace DDIS\lang\app\Repository\Interfaces;


use Illuminate\Support\Collection;

/**
 * Interface RepositoryInterface
 * @package DDIS\lang\app\Repository\Interfaces
 */
interface RepositoryInterface
{
    /**
     * Return all related objects
     * @return array
     */
    public function getAll():array ;

    /**
     * Get object with relations by id
     * @param string $id
     * @return Collection
     */
    public function get(string $id):Collection;

    /**
     * Get single object by id
     * @param string $id
     * @return mixed
     */
    public function model(string $id);

    /**
     * set new object
     * @param array $params
     * @return Collection
     */
    public function set(array $params):Collection;

    /**
     * update object by id
     * @param array $params
     * @param string $id
     * @return Collection
     */
    public function update(array $params,string $id):Collection;

    /**
     * delete object by id
     * @param string $id
     * @return bool
     */
    public function delete(string $id):bool;


}