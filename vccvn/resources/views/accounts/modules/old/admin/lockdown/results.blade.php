@php
$profile = getUser();
$addArgs = [];
$date = request()->open_date;
@endphp
@extends($_layout.'admin')
@section('title', 'Danh sách đã duyệt')
@section('content')

    <div class="ms-panel">
        <div class="ms-panel-header">
            <div class="filter-block align-middle">
                <form action="{{route('admin.bettings.results.data')}}" method="get" id="result-form" class="filter-form">
                    <div class="form-group row mb-0">
                        <div class="col-6 col-sm-4 col-md-2">
                            <div class="input-group">
                                {!! 
                                    html_input([
                                        'type' => 'select',
                                        'name' => 'area_id',
                                        'id' => 'area-id-input',
                                        'class' => 'form-control',
                                        'data' => $areaOptions
                                    ])
                                !!}
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-2">
                            <div class="input-group">
                                {!! 
                                    html_input([
                                        'type' => 'select',
                                        'name' => 'type_id',
                                        'id' => 'type-id-input',
                                        'class' => 'form-control',
                                        'data' => $typeOptions
                                    ])
                                !!}
                            </div>
                        </div>
                        <div class="col-6  col-sm-4 col-md-3 ">
                            <div class="input-group">
                                <input type="text" name="open_date" id="open-date-input" class="form-control date-picker" placeholder="Ngày mở thưởng" data-format="yy-mm-dd" value="{{$date}}" autocomplete="off">
                                <div class="input-group-append">
                                    <label for="open-date-input" class="mt-0 input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-12 col-md-5 text-sm-center text-md-left">
                            <div class="input-group">
                                <button type="button" class="btn btn-info btn-get-data">
                                    <i class="fa fa-eye"></i> Xem
                                </button>
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        
        </div>
        <div class="ms-panel-body">
                
            <div class="table-responsive">
                <table id="betting-list" class="table table-bordered thead-primary type-table smart-table text-sm-center" >

                </table>
            </div>


        </div>
    </div>
@endsection


@section('js')

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    <script>
        var $table = App.smarttable.setup({
            el: '#betting-analytics',
            filterForm: '#result-form',
            urls: {!! json_encode([
                'data' => route('admin.lockdown.bettings.data')
            ]) !!},
            item: {
                id: 'id'
            },
            // checklist: "id",
            // tools: [
            //     // '<a href="javascript:void(0)" class="btn btn-info btn-action-all approve px-2 py-1"><i class="fa fa-check-circle"></i></a>',
            //     '<a href="javascript:void(0)" class="btn btn-danger btn-lock-all unapprove px-2 py-1"><i class="fa fa-ban"></i></a>'
            // ],
            pagination: {
                per_page: 10,
                size: 5
            },

            columns: [
                {
                    title: 'ID',
                    className: "",
                    // scope: "row",
                    content: '{$id}'
                },
                {
                    title: "Họ tên",
                    className: "",
                    content: '{$user.name}'
                },
                {
                    title: "Loại cược",
                    className: "hide-xs text-left",
                    content: '<strong>K.Vực</strong>: {$area.name} <br><strong>Loại</strong>: {$type.name}'
                },
                {
                    title: "Con thắng",
                    className: "",
                    content: '<div class="max-250 m-auto">{$win_text}</div>'
                },
                {
                    title: "Điểm",
                    className: "",
                    content: '{$points}'
                },
                {
                    title: "Tổng cược",
                    className: "",
                    content: '{$total_point}'
                },
                {
                    title: "Tỷ lệ",
                    className: "",
                    content: '{$rate}'
                },
                {
                    title: "Tổng Thắng",
                    className: "",
                    content: '{$total_point_text}'
                }
            ],
            numberFormat: ['points', 'total_point', 'win_points', 'total_point_text'],
            parseItem: function (item) {
                var win_text = [];
                var total_point_text = 0;
                for (let i = 0; i < item.win_numbers.length; i++) {
                    const nb = item.win_numbers[i];
                    win_text.push(nb.number + (nb.match_count > 1 ? " (x"+nb.match_count+")": ""));
                    total_point_text += ((item.type.incremental ? nb.match_count : 1) * item.points * item.rate);
                }
                item.win_text = win_text.join(", ");
                item.total_point_text = total_point_text;
                item.total_point = item.points * item.number_count;
                if (item.is_win == 0) {
                    item.btns = '<a class="btn-action approve" href="#" data-id="' + item.number_id + '"><i class="far fa-check-circle ms-text-success mr-0"></i></a>';
                } else {
                    item.btns = '<a class="btn-action unapprove" href="#" data-id="' + item.number_id + '"><i class="fa fa-check-circle ms-text-success mr-0"></i></a>'
                }
                return item;
            }
        });
    
    
    </script>
@endsection