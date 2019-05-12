<?php
namespace DDIS\lang\app\Models\Mongodb;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class LangModel extends Eloquent {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $connection = 'mongodb';

    /**
     * HIDDEN TABLE ITEMS
     *
     * @var array
     */
    protected $hidden = [
        'created_at' ,'updated_at','deleted_at'
    ];

}