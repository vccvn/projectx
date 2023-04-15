@php
$profile = getUser();
$addArgs = [];
$date = request()->open_date;
@endphp
@extends($_layout.'admin')
@section('title', 'Kết quả Lotto')
{{-- @section('header_title', 'Kết quả xổ số') --}}
@section('show_sidebar', 1)
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
                                    <i class="fa fa-eye"></i> <span class="text-white d-none d-sm-inline d-md-none d-lg-inline ">Xem</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-checkout">
                                    <i class="fa fa-cogs"></i> <span class="text-white d-none d-sm-inline d-md-none d-lg-inline">Phân tích</span>
                                </button>

                                <button type="button" class="btn btn-success btn-download">
                                    <i class="fa fa-download"></i> <span class="text-white d-none d-sm-inline d-md-none d-lg-inline">Tải về</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        
        </div>
        <div class="ms-panel-body">
            {{-- <h4>Chuyển bảng</h4> --}}
            
            
                
            <div class="">
                <table id="betting-manager" class="table table-bordered thead-primary type-table smart-table text-sm-center" >

                    {{--                     
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-left">
                                <a class="btn btn-success btn-check-all px-2 py-1" href="#"><i class="fas fa-check"></i></a>
                            </td>
                        </tr>
                    </tfoot> --}}
                </table>
            </div>
            <div class="px-2">
                <div class="row">
                    <div class="col-md-6 text-center text-md-left mb-2">
                        <a class="btn btn-success btn-check-all px-2 py-1" href="#"><i class="fas fa-check"></i></a>
                        <a class="btn btn-primary btn-accept-all px-2 py-1" href="#"><i class="fa fa-check-square"></i></a>
                    </div>
                    <div class="col-md-6 text-center text-md-right">
                        <div class="d-inline-block">
                            {{-- {{$lottos->links($_template.'pagination')}} --}}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection


@section('js')
    <script>
        window.managerInit = function(){
            App.manager.init({
                urls: {!! json_encode([
                    'data' => route('admin.bettings.results.data'),
                    'checkout' => route('admin.bettings.results.checkout'),
                    'download' => route('admin.bettings.results.download'),
                ]) !!}
            })
        }
    </script>
    <script src="{{asset('assets/app/js/app.datatable.js')}}"></script> 
    <script src="{{asset('assets/app/js/betting.manager.js')}}"></script> 
    <script>
        var printCounter = 0;
        App.datatable.add({
            el: "#betting-manager",
            type: "ajax",
            order: [],
            columnDefs: [ {
                "targets": [0],
                orderable: false,
            }],
            columns: [
                {
                    title: '<label class="ms-checkbox-wrap ms-checkbox-warning"><input type="checkbox" class="checkbox check-all" name="checkall">  <i class="ms-checkbox-check"></i></label>',
                    className: "",
                    scope: "row",
                    content: '<label class="ms-checkbox-wrap"><input type="checkbox" class="checkbox check-item" name="items[]" value="{$number_id}"> <i class="ms-checkbox-check"></i></label>'
                },
                {
                    title: "Khu vực",
                    className: "hide-xs",
                    content: '{$area.name}'
                },
                {
                    title: "Hình thức",
                    className: "hide-xs",
                    content: '{$type.name}'
                },
                {
                    title: "Nội dung cược",
                    className: "",
                    content: '{$number}'
                },
                {
                    title: "Trùng khớp",
                    className: "hide-sm",
                    content: '{$match_count}'
                },
                {
                    title: "Act",
                    className: "text-center",
                    content: '<a class="btn-action approve" href="#" data-id="{$number_id}"><i class="fa fa-check-circle ms-text-success"></i></a>'
                },
    
                
            ],
            urls: {!! json_encode([
                'dataUrl' => route('admin.bettings.results.data'),
                
            ]) !!}
        })
    </script>
@endsection