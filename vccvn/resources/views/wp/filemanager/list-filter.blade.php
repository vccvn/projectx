<?php
$request = request();

$keyword = $request->search;

$searchby = $request->searchby;
// tim kiem
if(!isset($searchable)){
    $searchable = [];
}elseif(!is_array($searchable)){
    $searchable = explode(',', str_replace(' ','',$searchable));
}

$searchable = array_merge(['' => 'Tìm theo...'], $searchable);


// them css

add_custom_css('.filter-block .filter-form div[class*="col-"]', [
    'margin-bottom' => '15px'
]);


?>

        <div class="filter-block align-middle">
            <form action="{{$search_url??''}}" method="get" class="filter-form">
                <div class="form-group row mb-0">
                    <div class="col-sm-6 col-md-7">
                        <div class="input-group">
                            <input type="text" class="form-control " name="search" value="{{$keyword}}" placeholder="Nhập từ khóa">

                        </div>
                    </div>



                   <div class="col-12 col-sm-6 col-md-1">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> <span class="d-md-none">Tìm kiếm</span> </button>
                    </div>
                </div>
            </form>
        </div>
