<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['user_id', 'url_code', 'long_url', 'short_url'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
