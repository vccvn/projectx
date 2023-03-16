<?php

namespace App\Repositories\Transactions;

use App\Repositories\Base\BaseRepository;

class TransactionRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Transactions\TransactionValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\TransactionResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\TransactionCollection';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Transaction::class;
    }

}