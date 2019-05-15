<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 07/05/2019
 * Time: 01:09 PM
 */

namespace DDIS\lang\app\Http\Controllers\API;


use DDIS\lang\app\Exceptions\EmptyException;
use DDIS\lang\app\Http\Controllers\Absracts\LangControllerAbstract;
use DDIS\lang\app\Services\SentenceService;
use DDIS\lang\app\Traits\ApiResponse;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class SentenceController extends LangControllerAbstract
{
    use ApiResponse;
    private $Service;

    public function __construct(SentenceService $service)
    {
        $this->Service = $service;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        try {
//            $this->setMeta('status', 'success');
            $this->setData('sentences',$this->Service->getAll());
            return Response()->json($this->setResponse(),Response::HTTP_OK);
        } catch (EmptyException $e) {
            $this->setMeta('status', 'fail');
            $this->setMeta('message', $e->getMessage());
            return Response()->json($this->setResponse(),Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        try {
//            $this->setMeta('status', 'success');
            $this->setData('sentence',$this->Service->model($id));
            return Response()->json($this->setResponse(),Response::HTTP_OK);
        } catch (EntryNotFoundException $e) {
            $this->setMeta('status', 'fail');
            $this->setMeta('message', $e->getMessage());
            return Response()->json($this->setResponse(),Response::HTTP_NOT_FOUND);
        }
    }

    public function getByForm($id)
    {
        try {
//            $this->setMeta('status', 'success');
            $this->setData('sentences',$this->Service->get($id));
            return Response()->json($this->setResponse(),Response::HTTP_OK);
        } catch (EntryNotFoundException $e) {
            $this->setMeta('status', 'fail');
            $this->setMeta('message', $e->getMessage());
            return Response()->json($this->setResponse(),Response::HTTP_NOT_FOUND);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function set(Request $request)
    {
        $params = $request->all();
        try {
            $this->setMeta('status', 'success');
            $this->setData('sentence', $this->Service->set($params));
            return response()->json($this->setResponse(), Response::HTTP_OK);
        } catch (ValidationException $e) {
            $this->setMeta('status', 'fail');
            $this->setMeta('message', $e->getMessage());
            return response()->json($this->setResponse(), Response::HTTP_NOT_ACCEPTABLE);
        } catch (EmptyException $e) {
            $this->setMeta('status', 'fail');
            $this->setMeta('message', $e->getMessage());
            return response()->json($this->setResponse(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        try {
            $this->setMeta('status', 'success');
            $this->setData('sentence', $this->Service->update($params,$id));
            return response()->json($this->setResponse(), Response::HTTP_OK);
        } catch (ValidationException $e) {
            $this->setMeta('status', 'fail');
            $this->setMeta('message', $e->getMessage());
            return response()->json($this->setResponse(), Response::HTTP_NOT_ACCEPTABLE);
        } catch (EntryNotFoundException $e) {
            $this->setMeta('status', 'fail');
            $this->setMeta('message', $e->getMessage());
            return response()->json($this->setResponse(), Response::HTTP_NOT_FOUND);
        }
    }

    public function delete($id)
    {
        try{
            $this->setMeta('status', 'success');
            $this->setData('delete',$this->Service->delete($id));
            return Response()->json($this->setResponse(),Response::HTTP_OK);
        } catch (EntryNotFoundException $e){
            $this->setMeta('status', 'fail');
            $this->setMeta('message', $e->getMessage());
            return Response()->json($this->setResponse(),Response::HTTP_NOT_FOUND);
        }

    }
}