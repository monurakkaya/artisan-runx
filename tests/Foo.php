<?php

namespace Monurakkaya\ArtisanRunx\Tests;

use Illuminate\Database\Eloquent\Model;

class Foo extends Model
{
    protected $table = 'foos';

    protected $guarded = [];

    public $timestamps = false;
}
