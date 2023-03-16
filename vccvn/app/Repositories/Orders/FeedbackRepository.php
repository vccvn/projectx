<?php

namespace App\Repositories\Orders;

use App\Repositories\Base\BaseRepository;

class FeedbackRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Orders\FeedbackValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\OrderFeedbackResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\OrderFeedbackCollection';

    
    protected $responseMode = 'resource';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\OrderFeedback::class;
    }

    
    public function init()
    {
        $this->setJoinable([
            ['join', 'customers', 'customers.id', '=', 'order_feedback.customer_id']
        ]);
        $columns = [
            'customer_name' => 'customers.name',
            'customer_email' => 'customers.email',
            
        ];
        $this->setSearchable($columns);
        $this->setSortable($columns);
        
        $this->setSelectable(array_merge(['order_feedback.*'], $columns));
    }
}