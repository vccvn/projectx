<?php 
$request = request();

$keyword = $request->search; 
$per_page = $request->per_page; 

$orderby = $request->orderby; 
$sorttype = $request->sorttype; 
$sort_list = ['' => 'Kiểu sắp xếp', 'ASC'=>'Tăng dần','DESC'=>'Giảm dần'];

if($sorttype && strtolower($sorttype)!='desc'){
    $sorttype = 'ASC';
}
$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];


// sap xep
if(!isset($sortable)){
    $sortable = [];
}elseif(!is_array($sortable)){
    $sortable = explode(',', str_replace(' ','',$sortable));
}

$sortable = array_merge(['' => 'Sắp xếp theo...'], $sortable);


// them css

add_custom_css('.filter-block .filter-form div[class*="col-"]', [
    'margin-bottom' => '15px'
]);


?>

        <div class="filter-block align-middle">
            <form action="" method="get" class="filter-form">
                <div class="form-group row mb-0">
                    <div class="col-sm-6 col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control " name="search" value="{{$keyword}}" placeholder="Nhập từ khóa">
                            
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        @include($_base.'forms.templates.crazyselect', [
                            'input' => html_input([
                                'type' => 'crazyselect',
                                'name' => 'category',
                                'call' => 'get_product_category_options',
                                '@label-type' => 'value',
                                'value' => $request->category
                            ])
                        ])
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="orderby" id="orderby" class="form-control">
                            @foreach($sortable as $key => $val)
                            <?php
                                if(is_numeric($key)){
                                    $v = $val;
                                }else{
                                    $v = $key;
                                }
                            ?>
                            <option value="{{$v}}" {{strtolower($orderby) == strtolower($v) ? 'selected':''}}>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="sorttype" id="sortype" class="form-control">
                            @foreach($sort_list as $k => $vl)
                            <option value="{{$k}}" {{strtoupper($sorttype) == $k ? 'selected':''}}>{{$vl}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-1">
                        <select name="per_page" id="per_page" class="form-control">
                            @foreach($per_pages as $val => $text)
                            <option value="{{$val}}" {{$val == $per_page ? 'selected':''}}>{{$text}}</option>
                            @endforeach
                        </select>
                
                    </div>
                   <div class="col-12 col-sm-6 col-md-1">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> <span class="d-md-none">Tìm kiếm</span> </button>
                    </div>
                </div>
            </form>
        </div>
    