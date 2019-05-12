<?php

namespace packages\DDIS\Tests\Feature;

use DDIS\lang\app\Models\Form;
use TestCase;


class LanguageTest extends TestCase
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
        $response = $this->call('GET', 'api/v1/DDIS/lang/forms');
        $this->assertEquals(404, $response->status());
//        $this->seeJson($this->loadSchema("meta"));
        $this->seeJson(["meta"=>["message"=> "Object not found","status" => "fail"]]);
    }

    public function testForms_200()
    {
        $form= factory(Form::class,20)->create();

        $response = $this->call('GET', 'api/v1/DDIS/lang/forms');
        $this->assertEquals(200, $response->status());
//        $this->seeJson(  $this->loadSchema('forms.200'));
        $this->seeJson(['data' => ['forms' =>['data' => [['_id' =>$form->first()->_id , 'title' => $form->first()->title ]]]]] );
    }


    public function testForm_404()
    {
        $response = $this->call('GET', 'api/v1/DDIS/lang/form/a');

        $this->assertEquals(404, $response->status());
//        $this->seeJson(  $this->loadSchema('meta')) ;
        $this->seeJson(["meta"=>["message"=> "Object not found","status" => "fail"]]);
    }

    public function testForm_200()
    {
        $form= factory(Form::class,5)->create();

        $response = $this->call('GET', '/api/v1/DDIS/lang/form/'.$form->first()->_id);
        $this->assertEquals(200, $response->status());
//        $this->seeJson(  $this->loadSchema('form.200')) ;
        $this->seeJson(['data' => ['form' =>['_id' =>$form->first()->_id, 'title' =>$form->first()->title]]]);
    }


    public function testNewForm_406()
    {
        $response = $this->call('POST','api/v1/DDIS/lang/form');
        $this->assertEquals(406, $response->status());
//        $this->seeJson($this->loadSchema("meta"));
        $this->seeJson(["meta"=>["message"=> "The given data was invalid.","status" => "fail"]]);
    }



    public function testNewForm_200()
    {
        $response = $this->call('POST','api/v1/DDIS/lang/form',['title'=>'newTitleString']);
        dd($response);
        $this->assertEquals(200, $response->status());
//        $this->seeJson(  $this->loadSchema('form.200')) ;
        $this->seeJson(['data' => ['form' =>['title' => 'newTitleString']]]);
    }



    public function testUpdateForm_406()
    {
        $form= factory(Form::class,5)->create();

        $response = $this->call( 'PUT','api/v1/DDIS/lang/form/'.$form->first()->_id);
        $this->assertEquals(406, $response->status());
//        $this->seeJson($this->loadSchema("meta"));
        $this->seeJson(["meta"=>["message"=> "The given data was invalid.","status" => "fail"]]);
    }


    public function testUpdateForm_404()
    {

        $response = $this->call( 'PUT','api/v1/DDIS/lang/form/a',['title'=>'editedTitle']);
        $this->assertEquals(404, $response->status());
//        $this->seeJson(  $this->loadSchema('meta')) ;
        $this->seeJson(["meta"=>["message"=> "Object not found","status" => "fail"]]);
    }



    public function testUpdateForm_200()
    {
        $form= factory(Form::class,5)->create();

        $response = $this->call( 'PUT','api/v1/DDIS/lang/form/'.$form->first()->_id,['title'=>'editedTitle']);
        $this->assertEquals(200, $response->status());
//        $this->seeJson(  $this->loadSchema('form.200')) ;
        $this->seeJson(['data' => ['form' =>['title' => 'editedTitle']]]);
    }

    public function testDeleteForm_404()
    {

        $response = $this->call( 'DELETE','api/v1/DDIS/lang/form/a');
        $this->assertEquals(404, $response->status());
//        $this->seeJson($this->loadSchema("meta"));
        $this->seeJson(["meta"=>["message"=> "Object not found","status" => "fail"]]);
    }


    public function testDeleteForm_200()
    {
        $form= factory(Form::class,5)->create();

        $response = $this->call( 'DELETE','api/v1/DDIS/lang/form/'.$form->first()->_id);
        $this->assertEquals(200, $response->status());
//        $this->seeJson(  $this->loadSchema('form.delete')) ;
        $this->seeJson(['data' => ['delete'=>'True']]);
    }

}
