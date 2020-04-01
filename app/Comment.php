<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'name',
        'title',
        'body',
        'email'
    ];
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
