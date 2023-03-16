<?php

namespace App\Models;

class WebData extends Model
{
    public $table = 'web_data';
    public $fillable = ['data_group', 'ref', 'name', 'value', 'type', 'label', 'owner_id'];
    public $timestamps = false;

}
