<?php

namespace App\Models;

use App\Masks\Categories\CategoryMask;
use App\Masks\Users\AuthorMask;

class BasePost extends Model
{
    public $table = 'posts';
    public $fillable = [
        'author_id', 'dynamic_id', 'parent_id', 'category_id', 'category_map',
        'type', 'content_type', 'title', 'slug', 'keywords', 'description', 'content', 'feature_image', 'views',
        'privacy', 'deleted'
    ];

    /**
     * @var array $jsonFields các cột dùng kiểu json
     */
    protected $jsonFields = ['resources'];

    // public $resources = [];
    /**
     * ket noi voi bang user_meta
     * @return queryBuilder 
     */
    public function metadatas()
    {
        return $this->hasMany('App\Models\Metadata', 'ref_id', 'id')->where('ref', $this->ref);
    }
    
    /**
     * danh mục
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    /**
     * danh mục
     */
    public function dynamic()
    {
        return $this->belongsTo('App\Models\Dynamic', 'dynamic_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id')->select('id', 'name', 'avatar');
    }

    public function tagRefs()
    {
        return $this->hasMany('App\Models\TagRef', 'ref_id', 'id')->where('tag_refs.ref', $this->type);
    }
    public function postTags()
    {
        return $this->hasMany('App\Models\TagRef', 'ref_id', 'id')->where('tag_refs.ref', $this->ref);
    }

    public function tags()
    {
        return $this->postTags()->join('tags', 'tag_refs.tag_id', '=', 'tags.id')->select('tag_refs.*', 'tags.name', 'tags.keyword', 'tags.slug');
    }

    public function tagList()
    {
        return $this->tagRefs()->join('tags', 'tag_refs.tag_id', '=', 'tags.id')->select('tag_refs.*', 'tags.name', 'tags.keyword', 'tags.slug');
    }

    public function gallery()
    {
        return $this->hasMany('App\Models\File', 'ref_id', 'id')->where('ref', $this->ref);
    }

    /**
     * page con
     */
    public function children()
    {
        return $this->hasMany('App\Models\BasePost', 'parent_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'ref_id', 'id')->where('ref', $this->ref);
    }

    public function publishComments()
    {
        return $this->comments()->where('privacy', 'public')->where('parent_id', 0)->where('approved', 1);
    }


    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $this->applyMeta();
        $data = $this->toArray();
        if ($this->feature_image) {
            $data['feature_image'] = $this->getThumbnail();
        }
        $tags = [];
        if (count($this->tagRefs)) {
            foreach ($this->tagRefs as $tagged) {
                $tags[] = $tagged->tag_id;
            }
        }
        $data['tags'] = $tags;
        return $data;
    }


    /**
     * lay61 key words
     *
     * @return void
     */
    public function getSeoKeywords()
    {
        $data = [];
        if ($this->keywords) $data[] = $this->keywords;
        if (count($tags = $this->tagList)) {
            foreach ($tags as $key => $tag) {
                $data[] = $tag->keyword;
            }
        }
        return implode(', ', $data);
    }


    public function getViewUrl()
    {
        $url = $this->type == 'post' ? get_post_url($this) : ($this->type == 'page' ? get_page_url($this) : ($this->type == 'project' ? get_project_url($this) : (null)));

        return $url;
    }


    /**
     * get video url
     *
     * @return Arr|null
     */
    public function getVideo()
    {
        if ($video = $this->meta('video_url')) {
            return get_video_from_url($video);
        }
        return null;
    }

    /**
     * kiểm tra xem có gallery hay không
     *
     * @return boolean
     */
    public function hasGallery()
    {
        return count($this->gallery) > 0;
    }

    /**
     * lấy danh mục cha
     */

    public function getParent()
    {
        if (!$this->parent_id) return null;
        if ($this->relationLoaded('parent')) {
            $parent = $this->relations['parent'];
            if ($parent) {
                if (!check_model_data($this->type, $this->parent_id)) {
                    set_model_data($this->type, $this->parent_id, $parent);
                }
                return $parent;
            }
        }
        if (!($parent = get_model_data($this->type, $this->parent_id))) {
            $parent = $this->parent;
            if ($parent) {
                set_model_data($this->type, $this->parent_id, $parent);
            }
        }
        return $parent;
    }




    /**
     * lấy danh mục cha
     */

    public function getAuthor()
    {
        if ($this->author_id) {
            if ($this->relationLoaded('author')) {
                return new AuthorMask($this->relations['author']);
            }
            if (!($author = get_model_data('user', $this->author_id))) {
                $author = $this->author;
                if ($author) {
                    return new AuthorMask($author);
                }
            } else {
                return new AuthorMask($author);
            }
        }
        return new AuthorMask(new User(['name' => 'Anonymous', 'id' => 0]));
    }


    /**
     * lấy danh mục cha
     */

    public function getCategory()
    {
        if ($this->category_id) {
            if ($this->relationLoaded('category')) {
                $category = $this->relations['category'];
                if ($category) {
                    if (!check_model_data('category', $this->category_id)) {
                        set_model_data('category', $this->category_id, $category);
                    }
                    return new CategoryMask($category);
                }
            }
            if (!($category = get_model_data('category', $this->category_id))) {
                $category = $this->category;
                if ($category) {
                    set_model_data('category', $this->parent_id, $category);
                    return new CategoryMask($category);
                }
            } else {
                return new CategoryMask($category);
            }
        }
        return new CategoryMask(new Category(['name' => "Chưa phân loại", 'id' => 0]));
    }




    /**
     * map page
     */
    public function getMap($list = [], $n = 0)
    {
        if (!is_array($list)) $list = [];
        if (!is_integer($n)) $n = 0;
        array_unshift($list, $this->id);
        $n++;
        if ($parent = $this->getParent()) {
            return $parent->getMap($list, $n);
        }
        return $list;
    }

    // Cây cha con
    public function getTree($list = [], $n = 0)
    {
        if (!is_array($list)) $list = [];
        if (!is_integer($n)) $n = 0;
        array_unshift($list, $this);
        $n++;
        if ($parent = $this->getParent()) {
            return $parent->getTree($list, $n);
        }
        return $list;
    }

    /**
     * lấy tên thư mục chứa ảnh thumbnail / feature image
     * @return string tên tư mục
     */
    public function getImageFolder(): string
    {
        return str_plural($this->type);
    }


    /**
     * get image url
     * @param string $size
     * @return string 
     */
    public function getFeatureImage($size = false)
    {
        if ($this->feature_image) {
            $feature_image = $this->feature_image;
        } else {
            $feature_image = 'default.png';
        }
        $fd = $this->getImageFolder();
        if ($size) {
            return asset('static/' . $fd . '/' . $size . '/' . $feature_image);
            
        }
        return asset('static/' . $fd . '/' . $feature_image);
    }

    public function getThumbnail()
    {
        if ($this->feature_image) {
            $feature_image = $this->feature_image;
        } else {
            $feature_image = 'default.png';
        }
        $fd = $this->getImageFolder();
        if (file_exists(public_path('static/' . $fd . '/thumbs/' . $feature_image))) {
            return asset('static/' . $fd . '/thumbs/' . $feature_image);
        }
        return asset('static/' . $fd . '/' . $feature_image);
    }

    // lấy hình ảnh theo kích thước

    public function getImage($size = null)
    {
        if (!$size) {
            return $this->getFeatureImage();
        } elseif (in_array($size, ['thumb',  'thumbnail'])) {
            return $this->getThumbnail();
        } elseif (in_array($size, ['social',  '90x90'])) {
            return $this->getFeatureImage($size);
        } else {
            if ($this->feature_image) {
                $feature_image = $this->feature_image;
            } else {
                $feature_image = 'default.png';
            }
            return asset('static/' . $this->getImageFolder() . '/' . $size . '/' . $feature_image);
        }
    }
    /**
     * xoa image
     */
    public function deleteFeatureImage()
    {
        $fd = $this->getImageFolder();
        if ($this->feature_image && file_exists($path = public_path('static/' . $fd . '/' . $this->feature_image))) {
            unlink($path);
            if (file_exists($p = public_path('static/' . $fd . '/90x90/' . $this->feature_image))) {
                unlink($p);
            }
            if (file_exists($p = public_path('static/' . $fd . '/thumbs/' . $this->feature_image))) {
                unlink($p);
            }if (file_exists($p = public_path('static/' . $fd . '/social/' . $this->feature_image))) {
                unlink($p);
            }
        }
    }


    /**
     * ẩn tin bài
     */
    public function hidden()
    {
        $this->deleted++;
        $this->save();
    }

    /**
     * ẩn hiện tin bài
     */
    public function visible()
    {
        $this->deleted--;
        $this->save();
    }

    /**
     * ham xóa file cũ
     * @param int $id
     * 
     * @return boolean
     */
    public function deleteAttachFile()
    {
        return $this->deleteFeatureImage();
    }

    /**
     * lấy tên file đính kèm cũ
     */
    public function getAttachFilename()
    {
        return $this->feature_image;
    }

    /**
     * xóa tài nguyên
     */
    public function deleteResources()
    {
        $this->applyMeta();
        if ($this->resources && is_array($this->resources)) {
            $fd = $this->getImageFolder();
            foreach ($this->resources as $file) {
                if (file_exists($p = public_path('static/' . $fd . '/' . $file))) {
                    unlink($p);
                }
            }
        }
    }


    /**
     * xóa dữ liệu
     */
    public function beforeDelete()
    {
        // xóa tài nguyên
        $this->deleteResources();
        // delete meta
        if (count($this->metadatas)) {
            foreach ($this->metadatas as $metadata) {
                $metadata->delete();
            }
        }
        // deletegallery
        if (count($this->gallery)) {
            foreach ($this->gallery as $gallery) {
                $gallery->delete();
            }
        }
        // delete children
        if (count($this->children)) {
            foreach ($this->children as $child) {
                $child->delete();
            }
        }
        // delete children
        if (count($this->comments)) {
            foreach ($this->comments as $comment) {
                $comment->delete();
            }
        }

        // delete image
        $this->deleteFeatureImage();
    }
}
