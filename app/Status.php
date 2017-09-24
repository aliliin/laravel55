<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['content'];

    //跟用户关联
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
