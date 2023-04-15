<?php

namespace App\Models;

class Metadata extends Model
{
    public $table = 'metadatas';

    public $fillable = ['ref', 'ref_id', 'name', 'value'];

    public $timestamps = false;

}
