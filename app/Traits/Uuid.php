<?php

namespace App\Traits;

trait Uuid
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            if(empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = $model->uid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
    
    public function uid($limit = 16)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}