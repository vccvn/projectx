@php
$request = request();

$keyword = $request->search; 
$per_page = $request->per_page; 
$profile = getUser();
$addArgs = [];
$date = request()->date;
$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];

$actions = [];
            
@endphp
@extends($_layout.'admin')
@section('title', 'Action Audits')
@section('content')

    <div class="ms-panel">
        <div class="ms-panel-header">
            <?php 
            ?>
            
                    <div class="filter-block align-middle">
                        <form action="" method="get" class="filter-form">
                            <div class="form-group row mb-0">
                                <div class="col-8 col-sm-6 col-md-2  hide-xs">
                                    <div class="input-group">
                                        <input type="text" class="form-control " name="search" value="" placeholder="Nhập từ khóa">
                                        
                                    </div>
                                </div>
                                <div class="col-8 col-sm-6 col-md-3 ">
                                    <div class="input-group">
                                        <input type="text" name="date" id="date-input" class="form-control date-picker" placeholder="Ngày tháng"  data-format="yy-mm-dd" autocomplete="off">
                                        <div class="input-group-append">
                                            <label for="date-input" class="mt-0 input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 hide-xs">
                                    <div class="input-group">
                                        <select name="type" id="type" class="form-control">
                                            <option value="">Tất cả các loại</option>
                                            @foreach($types as $type)
                                            <?php
                                                $actions[$type['type']] = $type['actions']??[];
                                            ?>
                                            <option value="{{$type['type']}}">{{$type['type']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 hide-xs">
                                    <div class="input-group">
                                        <select name="action" id="action" class="form-control">
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
                
            
        
        </div>
        <div class="ms-panel-body">
            
            <div class="final-step">
                <div class="table-responsive">
                    <table id="audits" class="table table-bordered thead-primary type-table smarttable" >
    
                    </table>
                </div>    
            </div>


        </div>
    </div>
@endsection


@section('js')
    <script>

    window.smarttableInit = function(){
        var $audits = App.smarttable.setup({
            el: '#audits',
            filterForm: '.filter-form',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'           => route('admin.logs.audits.list.data')
            ]) !!},
            pagination: {
                per_page: 10,
                size: 5
            },
            columns: [
                {
                    title: "Tên",
                    className: "",
                    sortby: 'name',
                    content: '{$name}'
                },
                {
                    title: "Phân loại",
                    className: "",
                    sortby: 'type',
                    content: '{$type}'
                },
                {
                    title: "Thao tác",
                    className: "",
                    sortby: 'action',
                    content: '{$action}'
                },
                {
                    title: "Thời gian",
                    className: "",
                    sortby: 'created_at',
                    content: '{$created_time}'
                },
                {
                    title: "Chú thích",
                    className: "",
                    content: '{$message}'
                }
            ]
        });

        var actions = {!! json_encode($actions) !!};
        $(document).on("change", "select#type", function(){
            var value = $(this).val();
            var s = '<option value="">Tất cả các thao tác</option>';
            if(typeof actions[value] != "undefined"){
                for (const type in actions[value]) {
                    if (actions[value].hasOwnProperty(type)) {
                        const text = actions[value][type];
                        s += '<option value="'+type+'">'+text+'</option>';
                    }
                }
            }
            $('select#action').html(s);
        });
        

    }
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    
@endsection