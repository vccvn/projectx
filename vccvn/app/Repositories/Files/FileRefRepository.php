<?php

namespace App\Repositories\Files;

use App\Repositories\Base\BaseRepository;

class FileRefRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Files\FileRefValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'FileRefResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'FileRefCollection';

    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Files\FileRefMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Files\FileRefCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\FileRef::class;
    }

    

    /**
     * lấy các file của một ref nào đó
     * @param string $ref
     * @param int $ref_id
     * @return array
     */
    public function getFileRefs($ref = 'post', $ref_id = 0)
    {
        $data = [];
        if($ref_id && $files = $this->getBy(compact('ref', 'ref_id'))){
            foreach ($files as $file) {
                $data[] = $file->file_id;
            }
        }
        return $data;
    }
    
    /**
     * cập nhật danh sách file
     * @param string $ref
     * @param int $ref_id
     * @param array $file_id_list
     * @return array
     */
    public function updateFileRef(string $ref = 'post', int $ref_id, $file_id_list = [])
    {

        if(!is_array($file_id_list)) $file_id_list = [];
        $ingore = [];
        $addedData = [];
        //  duyệt tất cả các file của ref
        if(count($files = $this->get(compact('ref', 'ref_id')))){
            
            foreach ($files as $file) {
                // nếu file nằm trong số id them thì bỏ qua
                // không có trong danh sách mới thì xoá
                if(!in_array($file->file_id, $file_id_list)) 
                    $file->delete();
                else 
                    $ingore[] = $file->file_id;
                
            }
        }


         if(count($file_id_list)){
            foreach ($file_id_list as $file_id) {
                if(!in_array($file_id, $ingore)){
                    // nếu ko nằm trong danh sách bỏ qua thì ta thêm mới
                    $addedData[] = $this->save(compact('ref','ref_id', 'file_id'));
                }
            }
        }
        return $addedData;
    }

}