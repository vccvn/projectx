<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Crazy3DItemRef extends Model
{
    public $table = 'crazy_3d_item_refs';
    public $fillable = ['item_id', 'ref', 'ref_id', '__data__'];


    public $timestamps = false;    
    

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        '__data__' => 'array',
    ];

    /**
     * Get the item that owns the Crazy3DItemRef
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Crazy3DModelItem::class, 'item_id', 'id');
    }

    
    public function toMask()
    {
        $data = $this->getAttributes();
        // unset($data['__data__']);
        return $data;
    }

}
