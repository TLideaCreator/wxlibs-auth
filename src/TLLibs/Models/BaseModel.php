<?php


namespace TLLibs\Models;



use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Model;

abstract  class BaseModel extends Model
{
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model){
            if(empty($model->id)){
                $model->id = str_replace('-','', Uuid::uuid());
            }
        });
    }

}