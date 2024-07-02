<?php

namespace FredoAntonio\License;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'payload','status'
    ];

    public $timestamps = false;
}
