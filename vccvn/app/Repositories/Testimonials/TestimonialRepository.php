<?php

namespace App\Repositories\Testimonials;

use App\Repositories\Base\BaseRepository;
use Crazy\Helpers\Arr;

class TestimonialRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Testimonials\TestimonialValidator';
    
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Testimonials\TestimonialMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Testimonials\TestimonialCollection';

    
    /**
     * @var array $sortByRules kiểu sắp xếp
     */
    protected $sortByRules = [
        1 => 'id-DESC',
        2 => 'name-ASC',
        3 => 'name-DESC',
        4 => 'rand()'
    ];

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Testimonial::class;
    }



    public function beforeGetData($args = []){
        
        // sap xep danh sach
        $a = false;
        foreach (['', 'type', 'Type', '_type'] as $k) {
            if(isset($args['@sort'.$k])){
                if(!$a){
                    $this->parseSortBy($args['@sort'.$k]);
                    $a = true;
                }
                unset($args['@sort'.$k]);
            }    
        }
        
    }

    
}