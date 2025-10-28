<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayResult extends Model
{
    protected $fillable = ['link_id', 'random_number', 'win', 'amount'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
