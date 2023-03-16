<?php

namespace App\Repositories\Orders;

use App\Models\Order;
use App\Models\Promo;
use App\Models\UserDiscount;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Products\ProductAttributeRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Promos\PromoRepository;
use App\Repositories\Users\UserDiscountRepository;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;

class CartRepository extends BaseRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Order::class;
    }

    protected $validatorClass = 'Orders\CartValidator';
    protected $resourceClass = 'CartResource';
    protected $collectionClass = 'CartCollection';
    protected $maskClass = 'Orders\CartMask';
    protected $maskCollectionClass = 'Orders\CartCollection';
    protected $responseMode = 'mask';
    protected static $currentCartID = 0;
    /**
     * order
     *
     * @var Order
     */
    protected $cart = null;
    protected $currentAttrs = [];
    public $actionStatus = false;
    public $actionMessage = "Thao tác thành công";
    

    /**
     * repo
     *
     * @var \App\Repositories\Products\ProductAttributeRepository
     */
    protected $productAttributeRepository;

    /**
     * repo
     *
     * @var \App\Repositories\Products\ProductRepository
     */
    protected $productRepository;

    /**
     * repo
     *
     * @var OrderItemRepository
     */
    protected $orderItemRepository;

    /**
     * Undocumented variable
     *
     * @var PromoRepository
     */
    protected $promoRepository;
    /**
    * Undocumented variable
    *
    * @var UserDiscountRepository
    */
    protected $userDiscountRepository;
    
    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        $this->addDefaultCondition('type', 'type', 'cart');

        $this->productAttributeRepository = new ProductAttributeRepository();
        $this->productRepository = new ProductRepository();
        $this->productRepository->addDefaultCondition('deleted', 'deleted', 0);
        $this->orderItemRepository = new OrderItemRepository();
        $this->promoRepository = app(PromoRepository::class);
        $this->userDiscountRepository = app(UserDiscountRepository::class);

        if(!static::$currentCartID){
            $cookieCartId = Cookie::get('cart_id');
            if($cookieCartId){
                if(!is_numeric($cookieCartId)){
                    $cookieCartId = Crypt::decryptString($cookieCartId);
                }
                if($cookieCartId){
                    static::$currentCartID = $cookieCartId;

                }
            }
        }


    }

    public function makeCartExists()
    {
        if($this->cart) return $this->cart;
        if(static::$currentCartID && $cart = $this->first(['id' => static::$currentCartID])){
            // cart
            $this->cart = $cart;
        }else{
            $user_id = 0;
            if($user = auth()->user()){
                $user_id = $user->id;
            }
            $cart = $this->create(['name' => 'Customer', 'email' => 'example@gmail.com', 'user_id' => $user_id]);
            static::$currentCartID = $cart->id;
            $this->cart = $cart;
        }
        return $this->cart;
    }


    /**
     * thêm sản phẩm vào giỏ hàng
     *
     * @param int $product_id
     * @param int $quantity
     * @param array $attrs
     * @return Order
     */
    public function addItem($product_id, $quantity = 1, $attrs = [])
    {
        if($product = $this->productRepository->findBy('id', $product_id)){
            $this->makeCartExists();
            $order_id = static::$currentCartID;
            if(!is_numeric($quantity) || $quantity < 1) $quantity = 1;
            // lấy ra các id hợp lệ và mã hóa mảng json
            $attr_values = $this->getAttrKey($product->id, $attrs);
            // tạo biến data để uy cấn và cập nhật data
            $data = compact('order_id', 'product_id', 'attr_values');
            if($item = $this->orderItemRepository->first($data)){
                $cartItem = $item;
                $cartItem->quantity+=$quantity;
                $cartItem->save();
            }else{
                $data['quantity'] = $quantity;
                $data['list_price'] = $this->getProductPriceByOrigin($product->list_price,$product_id,$attrs);
                $data['final_price'] = $this->getProductPriceByOrigin($product->getFinalPrice(),$product_id,$attrs);
                $cartItem = $this->orderItemRepository->create($data);
            }
            return $this->updateCartData()->getCartWidthDetails();
        }
        return false;
    }

    /**
     * kiểm tra promo
     *
     * @param mixed $promo_id
     * @param integer $user_id
     * @return Promo
     */
    public function checkPromo($coupon, $user_id = 0)
    {
        if(!$coupon || !($currentTime = time())){
            $this->actionMessage = "Bạn chưa nhập mã giảm giá";
        }
        elseif(!($promo = $this->promoRepository->first(['code' => $coupon]))){
            $this->actionMessage = "Mã giảm giá không tồn tại";
        }
        elseif($promo->started_at && $currentTime < strtotime($promo->started_at)){
            $this->actionMessage = "Mã giảm giá hiện chưa có hiệu lục";
        }

        elseif($promo->finished_at && $currentTime > strtotime($promo->finished_at)){
            $this->actionMessage = "Mã giảm giá này hiện đã hết hiệu lục";
        }
        elseif($promo->scope == 'product'){
            $this->actionMessage = "Mã giảm giá này không áp dụng cho đơn hàng";
        }
        elseif($promo->scope == 'user' && (!($user_id || ($user = auth()->user())) || !($userDiscount = $this->userDiscountRepository->first(['user_id' => $user_id?$user_id:$user->id, 'discount_id' => $promo->id])))){
            $this->actionMessage = "Mã giảm giá này không dành cho bạn";
        }
        elseif($promo->scope == 'user' && ($userDiscount->usage >= $userDiscount->total)){
            $this->actionMessage = "Bạn đã dùng hết lượt khuyến mãi của mả giảm giá này";
        }
        elseif($promo->scope == 'order' && $promo->usage_total >= $promo->limited_total){
            $this->actionMessage = "Mã khuyến mãi này đã được sử dụng hết số lượng";
        }
        else{
            $this->actionStatus = true;
            return $promo;
        }
        return false;

    }

    /**
     * thêm sản phẩm vào giỏ hàng
     *
     * @param Request $request
     * @return Order
     */
    public function applyCoupon(Request $request)
    {

        if(!($promo = $this->checkPromo($request->coupon))){
            return false;
        }
        else{
            $this->makeCartExists();
            $this->cart->fill([
                'coupon' => $request->coupon,
                'promo_id' => $promo->id,
                'promo_type' => $promo->type
            ]);
            $this->cart->update();
            $this->actionStatus = true;
            return $this->updateCartData()->getCartWidthDetails();
        }


        return false;
    }


    public function removeItem(int $id = 0)
    {
        if($id){
            $this->makeCartExists();
            if($item = $this->orderItemRepository->first(['order_id' => $this->cart->id, 'id' => $id])){
                $item->delete();
            }
            return $this->updateCartData()->getCartWidthDetails();
        }
        return false;
    }

    public function updateCartQuantity($quantityData = [])
    {
        $s = false;
        if(is_array($quantityData)){
            $this->makeCartExists();
            foreach ($quantityData as $id => $qty) {
                if($qty < 1){
                    $this->orderItemRepository->delete($id);
                    $s = true;
                }elseif($this->orderItemRepository->update($id, ['quantity' => $qty])){
                    $s = true;
                }
            }
        }
        if($s){
            return $this->updateCartData()->getCartWidthDetails();
        }
        return false;

    }
    /**
     * lấy chi tiết giỏ hàng
     *
     * @return \App\Masks\Orders\CartMask|null
     */
    public function getCartWidthDetails()
    {
        return static::$currentCartID?$this->parseDetail($this->with('details')->first(['id' => static::$currentCartID])):null;
    }

    /**
     * làm trống giỏ hảng
     *
     * @return \App\Masks\Orders\CartMask|null
     */
    public function empty()
    {
        if(static::$currentCartID && $this->makeCartExists() && $this->cart){
            $this->cart->items()->delete();

            return $this->updateCartData()->getCartWidthDetails();
        }
        return false;
    }


    protected function updateCartData(){
        if($this->cart){
            $sub_total = 0;
            $total_money = 0;
            $shipping_fee = 0;
            $promo_type = 0;
            $promo_total = 0;
            if(count($items = $this->orderItemRepository->getBy('order_id', $this->cart->id))){
                foreach ($items as $item) {
                    $sub_total+=($item->final_price * $item->quantity);
                }
            }
            // thiết lập thêm tax hoặc gì đó
            $tax = 0;
            $total_money = $sub_total;
            if($this->cart->coupon && $promo = $this->checkPromo($this->cart->coupon, $this->cart->user_id?$this->cart->user_id:(($user = auth()->user())?$user->id: 0))){
                if($promo->type == Promo::TYPE_DOWN_PRICE){
                    $promo_total = $promo->down_price <= $total_money?$promo->down_price:$total_money;
                    $total_money-=$promo->down_price;
                    if($total_money<0) $total_money = 0;
                }
                elseif($promo->type == Promo::TYPE_DOWN_PERCENT){
                    $down = $promo->down_price*$total_money/100;
                    $promo_total = $down <= $total_money?$down:$total_money;
                    $total_money-=$down;
                    if($total_money<0) $total_money = 0;
                    
                }
                else{
                    $shipping_fee = 0;
                }
            }
            




            $this->cart = $this->update($this->cart->id, compact('sub_total','promo_total','total_money','tax', 'shipping_fee'));
        }
        return $this;
    }

    /**
     * lấy key của order item
     *
     * @param integer $product_id
     * @param array $attrs
     * @return string
     */
    public function getAttrKey(int $product_id, array $attrs = [])
    {
        $arr = [];
        if($attrs && $attrVals = $this->productAttributeRepository->getProductAttributeValues($product_id, $attrs, 1)){
            foreach ($attrVals as $attrVal) {
                $arr[] = $attrVal->attribute_value_id;
            }
        }
        sort($arr);

        return implode('-', $arr);
    }


    /**
     * lấy thông tin giá bán dự tên giá và thông tin đầu vào
     *
     * @param integer $origin_price
     * @param integer $product_id
     * @param array $attrs
     * @return void
     */
    public function getProductPriceByOrigin($origin_price = 0, $product_id = 0, $attrs = [])
    {
        if(!$this->currentAttrs){
            $this->currentAttrs = $this->productAttributeRepository->getProductAttributeValues($product_id, $attrs,1,1);
        }
        $price = $origin_price;
        if ($attrs) {
            $change = 0;
            if (count($this->currentAttrs)) {
                foreach ($this->currentAttrs as $key => $attr) {
                    if ($attr->price_type) {
                        if (!$change) {
                            $price = $attr->price;
                            $change = 1;
                        }
                    } else {
                        $price += $attr->price;
                    }
                }
            }
        }
        return $price;
    }

    public function getCartDetail($id)
    {
        return $this->with(['details', 'billing', 'shipping'])->mode('mask')->detail($id);
    }


    public function setCurrentCartID($id = null)
    {
        if(is_numeric($id)) static::$currentCartID = $id;
    }

    public function getCurrentCartID()
    {
        return static::$currentCartID;
    }



    public static function checkCartID(Request $request)
    {
        if(is_numeric($id = $request->cookie('cart_id'))){
            static::$currentCartID = $id;
        }
    }
}
