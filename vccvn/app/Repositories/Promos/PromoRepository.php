<?php

namespace App\Repositories\Promos;

use App\Repositories\Base\BaseRepository;

class PromoRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Promos\PromoValidator';
    

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Promos\PromoMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Promos\PromoCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Promo::class;
    }

    /**
     * lấy option còn hiệu lực
     *
     * @param array $args
     * @return array
     */
    public function getPromoAvailableOptions($args = [])
    {
        $this->whereDate('finished_at', '>=', date('Y-m-d'));
        $this->withCount('productRefs');
        $data = ['Chọn một chương trình khuyến mãi'];
        if(count($promos = $this->get($args))){
            foreach ($promos as $promo) {
                $data[$promo->id] = $promo->name . ' ('.$promo->productRefs_count . ' sản phẩm)';
            }
        }
        return $data;

    }

    /**
     * cập nhật danh sách user dc nhận promo
     * @param int $promo_id
     * @param array $user_id_list
     * @return void
     */
    public function updatePromoUsers(int $promo_id, array $user_id_list = [])
    {
        $ingore = [];
        if(count($users = $this->getBy('role_id', $promo_id))){
            foreach ($users as $user) {
                // nếu role nằm trong số id them thì bỏ qua
                if(in_array($user->user_id, $user_id_list)) $ingore[] = $user->user_id;
                // nếu ko thì xóa
                else $user->delete();
            }
        }
        if(count($user_id_list)){
            foreach ($user_id_list as $user_id) {
                if(!in_array($user_id, $ingore)){
                    // nếu ko nằm trong danh sách bỏ qua thì ta thêm mới
                    $this->save(compact('user_id', 'role_id'));
                }
            }
        }
    
    }

}