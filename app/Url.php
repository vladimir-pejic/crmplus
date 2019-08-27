<?php

namespace App;

class Url extends Model
{
    protected $fillable = ['user_id', 'url_code', 'long_url', 'short_url', 'clicks'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('long_url', 'like', '%'.$search.'%');
        });
    }
}
