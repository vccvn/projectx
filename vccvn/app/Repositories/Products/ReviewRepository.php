<?php

namespace App\Repositories\Products;

use App\Repositories\Base\BaseRepository;

class ReviewRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Products\ReviewValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\ProductReviewResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\ProductReviewCollection';

    /**
     * @var array $defaultSortBy Mảng key value là twen6 cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'product_reviews.id' => 'DESC'
    ];

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ProductReview::class;
    }

    public function init()
    {
        $this->setJoinable([
            ['join', 'products', 'products.id', '=', 'product_reviews.product_id'],
            ['leftJoin', 'customers', 'customers.id', '=', 'product_reviews.customer_id']
        ]);
        $columns = [
            'product_name' => 'products.name',
            'customer_name' => 'customers.name',
            'customer_email' => 'customers.email',
            
        ];
        $this->setSearchable($columns);
        $this->setSortable($columns);
        
        $this->setSelectable(array_merge(['product_reviews.*'], $columns));
    }
    public function getReviews($args = [], $advance = [])
    {
        $select = ['product_reviews.*'];
        if(in_array('customer', $advance) || in_array('user', $advance)){
            $this->join('customers', 'customers.id', '=', 'product_reviews.customer_id');
            $select = array_merge($select, ['customers.name as customer_name', 'customers.email as customer_email']);
        }
        if(in_array('user', $advance)){
            $this->join('users', 'users.id', '=', 'customers.user_id');
            $select = array_merge($select, ['users.name as user_name', 'users.email as user_email', 'users.avatar']);
        }
        if(in_array('product', $advance)){
            $this->join('products', 'products.id', '=', 'product_reviews.product_id');
            $select = array_merge($select, ['products.name as product_name', 'products.slug as product_slug', 'products.feature_image as feature_image']);
        }
        return $this->getData($args);
        
    }
}