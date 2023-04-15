<?php

namespace App\Repositories\Comments;

use App\Repositories\Base\BaseRepository;

class CommentRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Comments\CommentValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'CommentResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'CommentCollection';
    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Comments\CommentMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Comments\CommentCollection';

    /**
     * @var array $defaultSortBy Mảng key value là twen6 cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'comments.id' => 'DESC'
    ];
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Comment::class;
    }

    public function getComments(array $args = [])
    {
        return $this->getData($args);
    }

    public function beforeFilter($request)
    {
        $this->with(['publishChildren' => function($query){
            $query->with(['publishChildren' => function($query){
                $query->with('publishChildren');
            }]);
        }]);
    }
}