<?php

namespace App\Repositories\Base;

/**
 * các phương thúc với owner
 */
trait FileAction
{
    /**
     * ham xóa file cũ
     * @param int $id
     * 
     * @return boolean
     */
    public function deleteAttachFile($id)
    {
        if($result = $this->find($id)){
            return $result->deleteAttachFile();
        }
        return false;
    }

    /**
     * lấy tên file đính kèm cũ
     */
    public function getAttachFilename($id)
    {
        if($result = $this->find($id)){
            return $result->getAttachFilename();
        }
        return null;
    }

}
