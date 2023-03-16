<?php

namespace App\Repositories\Products;

use App\Repositories\Base\BaseRepository;

class ProductRefRepository extends BaseRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ProductRef::class;
    }


    /**
     * lấy các product của một ref nào đó
     * @param string $ref
     * @param int $ref_id
     * @return array
     */
    public function getProductRefs($ref = 'link', $ref_id = 0)
    {
        $data = [];
        if($ref_id && $products = $this->get(compact('ref', 'ref_id'))){
            foreach ($products as $product) {
                $data[] = $product->product_id;
            }
        }
        return $data;
    }
    
    /**
     * cập nhật danh sách product
     * @param string $ref
     * @param int $ref_id
     * @param array $product_id_list
     * @return void
     */
    public function updateProductRef(string $ref = 'link', int $ref_id, array $product_id_list = [])
    {

        $ignore = [];
        $addedData = [];
        if(count($products = $this->get(compact('ref', 'ref_id')))){
            foreach ($products as $product) {
                // nếu product nằm trong số id them thì bỏ qua
                if(!in_array($product->product_id, $product_id_list)) $product->delete();
                // nếu ko thì xóa
                else $ignore[] = $product->product_id;
            }
        }
        if(count($product_id_list)){
            foreach ($product_id_list as $product_id) {
                if(!in_array($product_id, $ignore)){
                    // nếu ko nằm trong danh sách bỏ qua thì ta thêm mới
                    $addedData[] = $this->save(compact('ref','ref_id', 'product_id'));
                }
            }
        }
        return $addedData;
    }

}