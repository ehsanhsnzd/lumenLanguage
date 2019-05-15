<?php

namespace packages\DDIS\Tests\Feature;

use DDIS\lang\app\Models\Form;
use DDIS\lang\app\Models\Sentence;
use TestCase;


class SentenceTest extends TestCase
{

    protected $schemas;
    protected $schemaFile =  "testType.php";
    public $sentence;
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

    public function testSentences_404()
    {
        $this->call('GET', 'api/v1/DDIS/lang/sentences');
        $this->seeStatusCode(404);
        $this->seeJsonStructure($this->loadSchema('meta'));
        $this->seeJson(["meta"=>["message"=> "Empty Data","status" => "fail"]]);
    }

    public function testSentences_200()
    {
        $sentence= factory(Sentence::class)->create();

        $this->call('GET', 'api/v1/DDIS/lang/sentences');
        $this->seeStatusCode(200);
        $this->seeJsonStructure($this->loadSchema('sentences.200'));
      /*  $this->seeJson(['data' => ['sentences' =>['current_page'=>1,'data' => ['_id'=> $sentence->_id ,'form_id'=>$sentence->form_id, 'slug' => $sentence->slug,
            'translate'=>
                ['en'=>'en',
                'fa'=>'fa',]
       ]]]]); */
    }
    public function testSentencesByForm_404()
    {
        $this->call('GET', 'api/v1/DDIS/lang/form/sentences/a');
        $this->seeStatusCode(404);
//        $this->seeJsonStructure($this->loadSchema('meta'));
        $this->seeJson(["meta"=>["message"=> "Object not found","status" => "fail"]]);
    }

    public function testSentencesByForm_200()
    {
        $sentence= factory(Sentence::class)->create();

        $this->call('GET', 'api/v1/DDIS/lang/form/sentences/'.$sentence->form_id);
        $this->seeStatusCode(200);
        $this->seeJsonStructure($this->loadSchema('sentences.200'));
      /*  $this->seeJson(['data' => ['sentences' =>['current_page'=>1,'data' => ['_id'=> $sentence->_id ,'form_id'=>$sentence->form_id, 'slug' => $sentence->slug,
            'translate'=>
                ['en'=>'en',
                'fa'=>'fa',]
       ]]]]); */
    }


    public function testSentence_404()
    {
        $this->call('GET', 'api/v1/DDIS/lang/sentence/a');
        $this->seeStatusCode(404);
        $this->seeJsonStructure(  $this->loadSchema('meta')) ;
        $this->seeJson(["meta"=>["message"=> "Model not found","status" => "fail"]]);
    }

    public function testSentence_200()
    {
        $sentence=factory(Sentence::class)->create();

        $this->call('GET', '/api/v1/DDIS/lang/sentence/'.$sentence->_id);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(  $this->loadSchema('sentence.200')) ;
        $this->seeJson(['data' => ['sentence' => ['_id'=> $sentence->_id ,'form_id'=>$sentence->form_id, 'slug' => $sentence->slug, 'translate'=>
            ['en'=>'en',
                'fa'=>'fa',]
        ]]]);
    }


    public function testNewSentence_406()
    {
        $this->call('POST','api/v1/DDIS/lang/sentence');
        $this->seeStatusCode(406);
        $this->seeJsonStructure($this->loadSchema("meta"));
        $this->seeJson(["meta"=>["message"=> "The given data was invalid.","status" => "fail"]]);
    }



    public function testNewSentence_200()
    {
        $sentence=factory(Sentence::class)->create();

        $this->call('POST','api/v1/DDIS/lang/sentence',['form_id'=>$sentence->form_id, 'slug' => $sentence->slug, 'translate'=>
            ['en'=>'en',
                'fa'=>'fa',]]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(  $this->loadSchema('sentence.200')) ;
/*        $this->seeJson(['data' => ['sentence' =>['_id'=>$sentence->_id, 'form_id'=>$sentence->form_id, 'slug' => $sentence->slug,  'translate'=>
            ['en'=>'en',
                'fa'=>'fa',]]]]);*/
    }



    public function testUpdateSentence_406()
    {
        $sentence= factory(Sentence::class)->create();

        $this->call( 'PUT','api/v1/DDIS/lang/sentence/'.$sentence->_id,['ok'=>'ok']);
        $this->seeStatusCode(406);
        $this->seeJsonStructure($this->loadSchema("meta"));
        $this->seeJson(["meta"=>["message"=> "The given data was invalid.","status" => "fail"]]);
    }


    public function testUpdateSentence_404()
    {

        $this->call( 'PUT','api/v1/DDIS/lang/sentence/a');
        $this->seeStatusCode(404);
        $this->seeJsonStructure(  $this->loadSchema('meta')) ;
        $this->seeJson(["meta"=>["message"=> "Model not found","status" => "fail"]]);
    }



    public function testUpdateSentence_200()
    {
        $sentence= factory(Sentence::class)->create();

        $this->call( 'PUT','api/v1/DDIS/lang/sentence/'.$sentence->_id,['translate'=>['en'=>'en']]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(  $this->loadSchema('sentence.200')) ;
        $this->seeJson(['data' => ['sentence' =>['_id'=>$sentence->_id,  'form_id'=>$sentence->form_id, 'slug' => $sentence->slug, 'translate'=>
            ['en'=>'en',
                'fa'=>'fa',]]]]);
    }

    public function testDeleteSentence_404()
    {
        $this->call( 'DELETE','api/v1/DDIS/lang/sentence/a');
        $this->seeStatusCode(404);
        $this->seeJsonStructure($this->loadSchema("meta"));
        $this->seeJson(["meta"=>["message"=> "Model not found","status" => "fail"]]);
    }


    public function testDeleteSentence_200()
    {
        $sentence= factory(Sentence::class,5)->create();

        $this->call( 'DELETE','api/v1/DDIS/lang/sentence/'.$sentence->first()->_id);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(  $this->loadSchema('sentence.delete')) ;
        $this->seeJson(['meta'=>['status'=>'success'], 'data' => ['delete'=>true]]);
    }

}
