<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Crazy3DTemplate extends Model
{
    public $table = 'crazy_3d_templates';
    public $fillable = ['user_id','category_id', 'name', 'description', 'keywords', 'status', 'secret_id', 'thumbnail', '__data__', 'deleted'];



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        '__data__' => 'array',
    ];
    
    

    /**
     * Get the user that owns the Crazy3DModelItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the category that owns the Crazy3DModelItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->where('type', '3d');
    }

    /**
     * Get all of the refs for the Crazy3DTemplate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemrefs(): HasMany
    {
        return $this->hasMany(Crazy3DItemRef::class, 'ref_id', 'id')->where('ref', 'template');
    }


    public function toFormData()
    {
        $data = $this->toArray();
        // $d = $this->__data__;
        // if (!is_array($d)) {
        //     try {
        //         $d = json_decode($d, true);
        //     } catch (\Throwable $th) {
        //         $d = [];
        //     }
        // }
        // foreach ($d as $key => $value) {
        //     $data[$key] = $value;
        // }
        $data['thumbnail_url'] = $this->getThumbnail();
        
        return $data;
    }

    public function toMask()
    {
        $data = $this->getAttributes();
        // unset($data['__data__']);
        return $data;
    }

    public function getThumbnail()
    {
        $path = 'static/sources/templates/' . $this->thumbnail;
        // dd($path);
        if ($this->thumbnail && file_exists(public_path($path))) {
            return asset($path);
        }
        return null;
    }

    public function beforeDelete()
    {
        if ($this->thumbnail && file_exists($p = public_path('static/sources/templates/' . $this->thumbnail))) {
            unlink($p);
        }
        # code...
    }
}
