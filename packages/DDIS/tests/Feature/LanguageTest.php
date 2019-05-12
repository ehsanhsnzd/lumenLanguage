<?php

namespace packages\DDIS\Tests\Feature;

use Laravel\Lumen\Testing\RefreshDatabase;
use packages\DDIS\lang\app\Traits\RefreshDatabaseTransactionLess;
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
        $response->assertStatus(404);
        $response->assertJsonStructure($this->loadSchema("meta"));
        $response->assertJson(['meta' => ['status'=>'fail']]);
    }

    public function testForms_200()
    {
        $form= factory(Form::class,20)->create();

        $response = $this->call('GET', 'api/v1/DDIS/lang/forms');
        $response->assertStatus(200);
        $response->assertJsonStructure(  $this->loadSchema('forms.200'));
        $response->assertJson(['data' => ['forms' =>['data' => [['_id' =>$form->first()->_id , 'title' => $form->first()->title ]]]]] );
    }


    public function testForm_404()
    {
        $response = $this->call('GET', 'api/v1/DDIS/lang/form/a');

        $response->assertStatus(404);
        $response->assertJsonStructure(  $this->loadSchema('meta')) ;
        $response->assertJson(['meta' => ['status'=>'fail']]);
    }

    public function testForm_200()
    {
        $form= factory(Form::class,5)->create();

        $response = $this->call('GET', '/api/v1/DDIS/lang/form/'.$form->first()->_id);
        $response->assertStatus(200);
        $response->assertJsonStructure(  $this->loadSchema('form.200')) ;
        $response->assertJson(['data' => ['form' =>['_id' =>$form->first()->_id, 'title' =>$form->first()->title]]]);
    }


    public function testNewForm_406()
    {
        $response = $this->postJson('api/v1/DDIS/lang/form');
        $response->assertStatus(406);
        $response->assertJsonStructure($this->loadSchema("meta"));
        $response->assertJson(['meta' => ['status'=>'fail']]);
    }



    public function testNewForm_200()
    {
        $response = $this->postJson('api/v1/DDIS/lang/form',['title'=>'newTitleString']);

        $response->assertStatus(200);
        $response->assertJsonStructure(  $this->loadSchema('form.200')) ;
        $response->assertJson(['data' => ['form' =>['title' => 'newTitleString']]]);
    }



    public function testUpdateForm_406()
    {
        $form= factory(Form::class,5)->create();

        $response = $this->putJson( 'api/v1/DDIS/lang/form/'.$form->first()->_id);
        $response->assertStatus(406);
        $response->assertJsonStructure($this->loadSchema("meta"));
        $response->assertJson(['meta' => ['status'=>'fail']]);
    }


    public function testUpdateForm_404()
    {

        $response = $this->putJson( 'api/v1/DDIS/lang/form/a',['title'=>'editedTitle']);
        $response->assertStatus(404);
        $response->assertJsonStructure(  $this->loadSchema('meta')) ;
        $response->assertJson(['meta' => ['status'=>'fail']]);
    }



    public function testUpdateForm_200()
    {
        $form= factory(Form::class,5)->create();

        $response = $this->putJson( 'api/v1/DDIS/lang/form/'.$form->first()->_id,['title'=>'editedTitle']);
        $response->assertStatus(200);
        $response->assertJsonStructure(  $this->loadSchema('form.200')) ;
        $response->assertJson(['data' => ['form' =>['title' => 'editedTitle']]]);
    }
    
    public function testDeleteForm_404()
    {

        $response = $this->deleteJson( 'api/v1/DDIS/lang/form/a');
        $response->assertStatus(404);
        $response->assertJsonStructure($this->loadSchema("meta"));
        $response->assertJson(['meta' => ['status'=>'fail']]);
    }


    public function testDeleteForm_200()
    {
        $form= factory(Form::class,5)->create();

        $response = $this->deleteJson( 'api/v1/DDIS/lang/form/'.$form->first()->_id);
        $response->assertStatus(200);
        $response->assertJsonStructure(  $this->loadSchema('form.delete')) ;
        $response->assertJson(['data' => ['delete'=>'True']]);
    }

}
