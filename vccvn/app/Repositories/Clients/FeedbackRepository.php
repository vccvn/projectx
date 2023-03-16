<?php

namespace App\Repositories\Clients;

use App\Repositories\Base\BaseRepository;

class FeedbackRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Clients\FeedbackValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'FeedbackResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'FeedbackCollection';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ClientFeedback::class;
    }

    public function init()
    {
        $this->setJoinable([
            ['join', 'clients', 'clients.id', '=', 'client_feedback.client_id']
        ]);
        $columns = [
            'client_name' => 'clients.name',
            'client_email' => 'clients.email',
            
        ];
        $this->setSearchable($columns);
        $this->setSortable($columns);
        
        $this->setSelectable(array_merge(['client_feedback.*'], $columns));
    }
}