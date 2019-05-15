<?php

namespace packages\DDIS\Tests\Feature;

use DDIS\lang\app\Models\Form;
use TestCase;


class FormTest extends TestCase
{

    protected $schemas;
    protected $schemaFile =  "testType.php";
    public $form;
    protected function loadSchema($key)
    {
        if (!is_array($this->schemas)) {
            $this->schemas = require __DIR__ . "/{$this->schemaFile}";
        }
        $schema = array_get($this->schemas, $key);
        if (!is_array($schema)) {
            exit("Schema $key does not exists.\n");
        }
        return $schema;
    }

    public function testForms_404()
    {
        $this->call('GET', 'api/v1/DDIS/lang/forms');
        $this->seeStatusCode(404);
        $this->seeJsonStructure($this->loadSchema('meta'));
        $this->seeJson(["meta"=>["message"=> "Empty Data","status" => "fail"]]);
    }

    public function testForms_200()
    {
        $form= factory(Form::class,20)->create();

        $this->call('GET', 'api/v1/DDIS/lang/forms');
        $this->seeStatusCode(200);
        $this->seeJsonStructure($this->loadSchema('forms.200'));
//        $this->seeJson(['data' => ['forms' =>['data' => ['_id' =>$form->first()->_id , 'title' => $form->first()->title ]]]]);
    }


    public function testForm_404()
    {
        $this->call('GET', 'api/v1/DDIS/lang/form/a');
        $this->seeStatusCode(404);
        $this->seeJsonStructure(  $this->loadSchema('meta')) ;
        $this->seeJson(["meta"=>["message"=> "Object not found","status" => "fail"]]);
    }

    public function testForm_200()
    {
        $form= factory(Form::class,5)->create();

        $this->call('GET', '/api/v1/DDIS/lang/form/'.$form->first()->_id);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(  $this->loadSchema('form.200')) ;
        $this->seeJson(['data' => ['form' =>['_id' =>$form->first()->_id, 'title' =>$form->first()->title]]]);
    }


    public function testNewForm_406()
    {
        $this->call('POST','api/v1/DDIS/lang/form');
        $this->seeStatusCode(406);
        $this->seeJsonStructure($this->loadSchema("meta"));
        $this->seeJson(["meta"=>["message"=> "The given data was invalid.","status" => "fail"]]);
    }



    public function testNewForm_200()
    {
        $this->call('POST','api/v1/DDIS/lang/form',['title'=>'newTitleString']);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(  $this->loadSchema('form.200')) ;
//        $this->seeJson(['data' => ['form' =>['id','title' => 'newTitleString']]]);
    }



    public function testUpdateForm_406()
    {
        $form= factory(Form::class,5)->create();

        $this->call( 'PUT','api/v1/DDIS/lang/form/'.$form->first()->_id);
        $this->seeStatusCode(406);
        $this->seeJsonStructure($this->loadSchema("meta"));
        $this->seeJson(["meta"=>["message"=> "The given data was invalid.","status" => "fail"]]);
    }


    public function testUpdateForm_404()
    {

        $this->call( 'PUT','api/v1/DDIS/lang/form/a',['title'=>'editedTitle']);
        $this->seeStatusCode(404);
        $this->seeJsonStructure(  $this->loadSchema('meta')) ;
        $this->seeJson(["meta"=>["message"=> "Object not found","status" => "fail"]]);
    }



    public function testUpdateForm_200()
    {
        $form= factory(Form::class,5)->create();

        $this->call( 'PUT','api/v1/DDIS/lang/form/'.$form->first()->_id,['title'=>'editedTitle']);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(  $this->loadSchema('form.200')) ;
        $this->seeJson(['data' => ['form' =>['_id'=>$form->first()->_id, 'title' => 'editedTitle']]]);
    }

    public function testDeleteForm_404()
    {
        $this->call( 'DELETE','api/v1/DDIS/lang/form/a');
        $this->seeStatusCode(404);
        $this->seeJsonStructure($this->loadSchema("meta"));
        $this->seeJson(["meta"=>["message"=> "Object not found","status" => "fail"]]);
    }


    public function testDeleteForm_200()
    {
        $form= factory(Form::class,5)->create();

        $this->call( 'DELETE','api/v1/DDIS/lang/form/'.$form->first()->_id);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(  $this->loadSchema('form.delete')) ;
        $this->seeJson(['meta'=>['status'=>'success'], 'data' => ['delete'=>true]]);
    }

}
