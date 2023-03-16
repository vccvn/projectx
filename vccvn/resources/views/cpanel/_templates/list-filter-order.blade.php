<?php 
$request = request();

$keyword = $request->search; 
$per_page = $request->per_page; 

$searchby = $request->searchby; 
$orderby = $request->orderby; 
$sorttype = $request->sorttype; 
$sort_list = ['' => 'Kiểu sắp xếp', 'ASC'=>'Tăng dần','DESC'=>'Giảm dần'];

if($sorttype && strtolower($sorttype)!='desc'){
    $sorttype = 'ASC';
}
$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];

// tim kiem
if(!isset($searchable)){
    $searchable = [];
}elseif(!is_array($searchable)){
    $searchable = explode(',', str_replace(' ','',$searchable));
}

$searchable = array_merge(['' => 'Tìm theo...'], $searchable);

// sap xep
if(!isset($sortable)){
    $sortable = [];
}elseif(!is_array($sortable)){
    $sortable = explode(',', str_replace(' ','',$sortable));
}

$sortable = array_merge(['' => 'Sắp xếp theo...'], $sortable);


$daterange = $request->daterange??'';


// them css

add_custom_css('.filter-block .filter-form div[class*="col-"]', [
    'margin-bottom' => '15px'
]);


?>

    <div class="filter-block align-middle">
        <form action="" method="get" class="filter-form">
            
            <div class="d-none d-md-block">
                <div class="form-group row mb-0">
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        @include($_base.'forms.templates.crazyselect', [
                            'input' => html_input([
                                'type' => 'crazyselect',
                                'name' => 'shipping_region_id',
                                'id' => 'shipping_region_id',
                                'default' => $request->shipping_region_id,
                                // 'class' => 'form-control m-input',
                                'call' => 'get_region_options',
                                'params' => [[], 'Khu vực giao hàng']
                            ])
                        ])
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        @include($_base.'forms.templates.crazyselect', [
                            'input' => html_input([
                                'type' => 'crazyselect',
                                'name' => 'payment_method',
                                'id' => 'payment_method',
                                'default' => $request->payment_method,
                                // 'class' => 'form-control m-input',
                                'call' => 'get_payment_method_options'
                            ])
                        ])
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        @include($_base.'forms.templates.crazyselect', [
                            'input' => html_input([
                                'type' => 'crazyselect',
                                'name' => 'status',
                                'id' => 'status',
                                'default' => $request->status,
                                // 'class' => 'form-control m-input',
                                'data' => [
                                    "" => "Trạng thái đơn hàng",
                                    200 => "Chờ thanh toán",
                                    400 => "Chờ xử lý",
                                    500 => "Đang giao hàng",
                                    1000=> "Đã hoàn thành",
                                    -1  => "Bị hủy",
                                ]
                            ])
                        ])
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3" id="daterange-form-group">
                        @include($_base.'forms.templates.daterange', [
                            'input' => html_input([
                                'type' => 'daterange',
                                'name' => 'daterange',
                                'id' => 'daterange',
                                'default' => $daterange,
                                'class' => 'form-control m-input',
                                'data-format' => 'YYYY-MM-DD',
                                'placeholder' => 'Nhập thời gian'
                            ])
                        ])
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="input-group">
                            <input type="text" class="form-control " name="search" value="{{$keyword}}" placeholder="Nhập từ khóa">
                            
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="input-group">
                            <select name="searchby" id="searchby" class="form-control">
                                @foreach($searchable as $key => $val)
                                <?php
                                    if(is_numeric($key)){
                                        $v = $val;
                                    }else{
                                        $v = $key;
                                    }
                                ?>
                                <option value="{{$v}}" {{strtolower($searchby) == strtolower($v) ? 'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                            
                            
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2">
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
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <select name="sorttype" id="sortype" class="form-control">
                            @foreach($sort_list as $k => $vl)
                            <option value="{{$k}}" {{strtoupper($sorttype) == $k ? 'selected':''}}>{{$vl}}</option>
                            @endforeach
                        </select>
                    </div>
                   <div class="col-12 col-sm-6 col-md-4 col-lg-1">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> <span class="d-md-none">Tìm kiếm</span> </button>
                    </div>
                </div>
            </div>

        </form>

        <form action="" method="get" class="filter-form">

            <!--begin::Section-->
            <div class="m-accordion m-accordion--bordered d-md-none" id="crazy-menu-detail" role="tablist">
                <!--begin::Item-->
                <div class="form-group row">
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="text" class="form-control " name="search" value="{{$keyword}}" placeholder="Nhập từ khóa">
                            
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <select name="searchby" id="searchby" class="form-control">
                                @foreach($searchable as $key => $val)
                                <?php
                                    if(is_numeric($key)){
                                        $v = $val;
                                    }else{
                                        $v = $key;
                                    }
                                ?>
                                <option value="{{$v}}" {{strtolower($searchby) == strtolower($v) ? 'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-12 col-sm-2">
                        <button type="submit" class="btn btn-primary btn-block pl-0 pr-0"><i class="fa fa-search"></i> <span class="d-sm-none">Tìm kiếm</span> </button>
                    </div>
                </div>
                <div class="m-accordion__item">
                    <div class="m-accordion__item-head collapsed" role="tab" id="crazy-fillter_head" data-toggle="collapse" href="#crazy-fillter_body" aria-expanded="false">
                        <span class="m-accordion__item-icon">
                            <i class="fa fa-filter"></i>
                        </span>
                        <span class="m-accordion__item-title">Bộ lọc</span>
                        <span class="m-accordion__item-mode"></span>
                    </div>
                    <div class="m-accordion__item-body collapse" id="crazy-fillter_body" class=" " role="tabpanel" aria-labelledby="crazy-fillter_head" data-parent="#crazy-menu-detail">
                        <div class="m-accordion__item-content pt-3 pl-0 pr-0">
                            <div class="form-group row mb-0">
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    @include($_base.'forms.templates.crazyselect', [
                                        'input' => html_input([
                                            'type' => 'crazyselect',
                                            'name' => 'shipping_region_id',
                                            'id' => 'shipping_region_id2',
                                            'default' => $request->shipping_region_id,
                                            // 'class' => 'form-control m-input',
                                            'call' => 'get_region_options',
                                            'params' => [[], 'Khu vực giao hàng']
                                        ])
                                    ])
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    @include($_base.'forms.templates.crazyselect', [
                                        'input' => html_input([
                                            'type' => 'crazyselect',
                                            'name' => 'payment_method',
                                            'id' => 'payment_method2',
                                            'default' => $request->payment_method,
                                            // 'class' => 'form-control m-input',
                                            'call' => 'get_payment_method_options'
                                        ])
                                    ])
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    @include($_base.'forms.templates.crazyselect', [
                                        'input' => html_input([
                                            'type' => 'crazyselect',
                                            'name' => 'status',
                                            'id' => 'status2',
                                            'default' => $request->status,
                                            // 'class' => 'form-control m-input',
                                            'data' => [
                                                "" => "Trạng thái đơn hàng",
                                                200 => "Chờ thanh toán",
                                                400 => "Chờ xử lý",
                                                500 => "Đang giao hàng",
                                                1000=> "Đã hoàn thành",
                                                -1  => "Bị hủy",
                                            ]
                                        ])
                                    ])
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3" id="daterange-form-group">
                                    @include($_base.'forms.templates.daterange', [
                                        'input' => html_input([
                                            'type' => 'daterange',
                                            'name' => 'daterange',
                                            'id' => 'daterange2',
                                            'default' => $daterange,
                                            'class' => 'form-control m-input',
                                            'data-format' => 'YYYY-MM-DD',
                                            'placeholder' => 'Nhập thời gian'
                                        ])
                                    ])
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-2">
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
                                <div class="col-sm-6 col-md-4 col-lg-2">
                                    <select name="sorttype" id="sortype" class="form-control">
                                        @foreach($sort_list as $k => $vl)
                                        <option value="{{$k}}" {{strtoupper($sorttype) == $k ? 'selected':''}}>{{$vl}}</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--end::Item-->

            </div>

    

        </form>
    </div>
