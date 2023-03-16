<?php

namespace App\Models;

class Metadata extends Model
{
    public $table = 'metadatas';

    public $fillable = ['owner_id', 'ref', 'ref_id', 'name', 'value'];

    public $timestamps = false;

}
