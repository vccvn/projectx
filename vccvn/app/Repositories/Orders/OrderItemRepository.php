<?php

namespace App\Repositories\Orders;

use Crazy\Helpers\Arr;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Products\ProductRepository;

class OrderItemRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Orders\OrderItemValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\OrderItemResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\OrderItemCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\OrderItem::class;
    }

    /**
     * loc và tinh gia tien don hang
     * @param array $items
     */
    public function parseItems(array $item_list = [])
    {
        $items = [];
        $total_money = 0;
        if(count($item_list)){
            $productRepository = new ProductRepository();
            foreach($item_list as $itm){
                $item = new Arr($itm);
                // nếu tìm thấy sản phẩm
                if($product = $productRepository->findBy('id', $item->product_id)){
                    // nạp một số thông tin từ sản phẩm sang 
                    // $item->order_id = $order_id;
                    $item->list_price = $product->list_price;
                    $item->final_price = $product->getFinalPrice();
                    $total_money += $item->final_price * $item->quantity;
                    if($product->hasPromo()){
                        $item->note = "Sản phẩm dược hưởng khuyến mãi";
                    }
                    $key = $item->product_id;
                    // xử lý thuộc tính nếu có
                    if($item->attr_values){
                        $av = array_values($item->attr_values);
                        sort($av);
                        $item->attr_values = $av;
                        $key .= '.'. implode('-', $av);
                    }
                    // kiểm tra sản phẩm trùng lặp
                    if(array_key_exists($key, $items)){
                        // trong trường hợp item trước đó đã có id thì + quantity vào key trước đó
                        if($items[$key]->id){
                            $items[$key]->quantity+=$item->quantity;
                        }
                        // trường hợp item hiện tại có id thì + quan tity vào item6 hiện tại và thế chỗ cho item trong mảng data
                        elseif ($item->id) {
                            $item->quantity+=$items[$key]->quantity;
                            $items[$key] = $item;
                        }
                        // trường hợp mới toanh không có item id thì cộng dồn
                        else{
                            $items[$key]->quantity+=$item->quantity;
                        }
                            
                    }else{
                        $items[$key] = $item;
                    }                    
                }
            }
        }

        return compact('items', 'total_money');
    }

    /**
     * cập nhật hoặc thêm mới order item
     * @param int $order_id Mã đơn hàng
     * @param array $items Danh sách item [['id' => $order_item_id, 'product_id' => $product_id, 'quantity' => $quantity, 'attributes' => []]]
     * 
     * @return bool
     */
    public function saveOrderItems(int $order_id, array $items = [])
    {
        $ignore = [];
        $data = [];
        if(count($items)){
            foreach ($items as $key => $item) {
                if($item->id){
                    $ignore[] = $item->id;
                }
                $item->order_id = $order_id;
                $data[$key] = $item;
            }
        }
        if(count($list = $this->getBy('order_id', $order_id))){
            foreach ($list as $orderItem) {
                if(!in_array($orderItem->id, $ignore)){
                    $orderItem->delete();
                }
            }
        }
        $dataSaved = [];
        if($data){
            foreach ($data as $key => $orderItem) {
                if(!$orderItem->id) $orderItem->remove('id');
                $itemdata = $orderItem->all();

                $dataSaved[] = $this->save($itemdata, $orderItem->id);
            }
        }
        return $dataSaved;
    }

    public function beforeSave($data)
    {
        if(isset($data['attr_values']) && is_array($data['attr_values'])){
            $data['attr_values'] = implode('-', $data['attr_values']);
        }
        return $data;
    }
}