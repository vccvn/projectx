<?php

namespace App\Repositories\DataTables;

use App\Repositories\Base\BaseRepository;

class DataTableRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'DataTables\DataTableValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'DataTableResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'DataTableCollection';

    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'DataTables\DataTableMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'DataTables\DataTableCollection';

    /**
     * @var \App\Models\DataTable
     */
    static $__Model__;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\DataTable::class;
    }

}