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

$date = $request->date;


?>

        <div class="filter-block align-middle">
            <form action="" method="get" class="filter-form">
                <div class="form-group row mb-0">
                    <div class="col-8 col-sm-6 col-md-2  hide-xs">
                        <div class="input-group">
                            <input type="text" class="form-control " name="search" value="{{$keyword}}" placeholder="Nhập từ khóa">
                            
                        </div>
                    </div>
                    <div class="col-8 col-sm-6 col-md-3 ">
                        <div class="input-group">
                            <input type="text" name="date" id="date-input" class="form-control date-picker" placeholder="Ngày tháng" value="{{$date}}" data-format="yy-mm-dd" autocomplete="off">
                            <div class="input-group-append">
                                <label for="date-input" class="mt-0 input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 hide-xs">
                        <div class="input-group">
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
                    </div>
                    <div class="col-6 col-md-2 hide-xs">
                        <div class="input-group">
                            <select name="sorttype" id="sortype" class="form-control">
                                @foreach($sort_list as $k => $vl)
                                <option value="{{$k}}" {{strtoupper($sorttype) == $k ? 'selected':''}}>{{$vl}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 hide-xs">
                        <div class="input-group">
                            <select name="per_page" id="per_page" class="form-control">
                                @foreach($per_pages as $val => $text)
                                <option value="{{$val}}" {{$val == $per_page ? 'selected':''}}>{{$text}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4 col-sm-6 col-md-1">
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                <span class="d-none d-sm-inline text-white"><i class="fa fa-search"></i></span> <span class="d-md-none text-white">Tìm</span> </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    
