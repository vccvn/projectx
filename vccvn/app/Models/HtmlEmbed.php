<?php

namespace App\Models;

class HtmlEmbed extends Model
{
    public $table = 'html_embeds';
    public $fillable = ['owner_id', 'area_id', 'label', 'slug', 'code', 'priority', 'status'];

    public $timestamps = false;
}
