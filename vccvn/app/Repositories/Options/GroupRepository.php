<?php

namespace App\Repositories\Options;

use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Str;
use Crazy\Helpers\Arr;

class GroupRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    // protected $validatorClass = 'App\Validators\Options\GroupValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'OptionGroupResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'OptionGroupCollection';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\OptionGroup::class;
    }

    /**
     * lấy thông tin các cột cần kiểm tra
     *
     * @return array
     */
    public function getCheckColimns()
    {
        $columns = ['slug', 'option_id'];
        if(!$this->getOwnerID()){
            $columns[] = 'owner_id';
        }
        return $columns;
    }


    /**
     * tạo ra môt option group nếu chưa tồn tại
     *
     * @param array $data
     * @return App\Models\OptionGroup
     */
    public function createDataIfNotExists(array $data = [], $callback = null)
    {
        // giá trị mặc định
        $default = ['slug' => null, 'label' => null, 'option_id' => 0];
        $checkColumns = $this->getCheckColimns();
        // thông tim đầu vào
        $inputs = new Arr(array_merge($default, $data));
        
        // nếu có yêu cầu kiểm tra owner_id mà trong input không có
        if(in_array('owner_id', $checkColumns) && !$inputs->isset('owner_id')) return null;
        // nếu thiếu cả label và slug thì trả về false
        if((!$inputs->slug && !$inputs->label) || !$inputs->option_id || !(new OptionRepository())->findBy('id', $inputs->option_id)) return null;
        // nếu không có slug thì gán label cho slug
        elseif(!$inputs->slug) $inputs->slug = Str::slug($inputs->label);
        // nếu không có label thì gán slug cho label
        elseif(!$inputs->label) $inputs->label = $inputs->slug;
        // để cho chắc chắn là slug sẽ luôn đúng định dạng
        $inputs->slug = Str::slug($inputs->slug);
        // tham số để kiểm tra xem tồn tại hay không
        $params = $inputs->copy($checkColumns);
        // kiểm tra xem tồn tại hay chưa
        if(!($optionGroup = $this->first($params))){
            // nếu chưa tồn tại thì tạo mới
            $optionGroup = $this->create($inputs->all());
        }
        if(is_callable($callback)){
            $callback($optionGroup);
        }
        return $optionGroup;
    }

    
    /**
     * tạo ra môt option group nếu chưa tồn tại
     *
     * @param array $data
     * @return App\Models\OptionGroup
     */
    public function createOrUpdate(array $data = [], $callback = null)
    {
        // giá trị mặc định
        $default = ['slug' => null, 'label' => null, 'option_id' => 0];
        $checkColumns = $this->getCheckColimns();
        // thông tim đầu vào
        $inputs = new Arr(array_merge($default, $data));
        
        // nếu có yêu cầu kiểm tra owner_id mà trong input không có
        if(in_array('owner_id', $checkColumns) && !$inputs->isset('owner_id')) return null;
        // nếu thiếu cả label và slug thì trả về false
        if((!$inputs->slug && !$inputs->label) || !$inputs->option_id || !(new OptionRepository())->findBy('id', $inputs->option_id)) return null;
        // nếu không có slug thì gán label cho slug
        elseif(!$inputs->slug) $inputs->slug = Str::slug($inputs->label);
        // nếu không có label thì gán slug cho label
        elseif(!$inputs->label) $inputs->label = $inputs->slug;
        // để cho chắc chắn là slug sẽ luôn đúng định dạng
        $inputs->slug = Str::slug($inputs->slug);
        // tham số để kiểm tra xem tồn tại hay không
        $params = $inputs->copy($checkColumns);
        // kiểm tra xem tồn tại hay chưa
        if(!($optionGroup = $this->first($params))){
            // nếu chưa tồn tại thì tạo mới
            $optionGroup = $this->create($inputs->all());
        }
        elseif ($og = $this->update($optionGroup->id, $inputs->all())) {
            $optionGroup = $og;
        }
        if(is_callable($callback)){
            $callback($optionGroup);
        }
        return $optionGroup;
    }
}