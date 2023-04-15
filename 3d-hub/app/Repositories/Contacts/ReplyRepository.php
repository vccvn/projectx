<?php

namespace App\Repositories\Contacts;

use App\Repositories\Base\BaseRepository;

class ReplyRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Contacts\ReplyValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'ContactReplyResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'ContactReplyCollection';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ContactReply::class;
    }

}