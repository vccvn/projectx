@php
// $profile = gettype();
// $jpod = ['all' => 'Tất cả', 0 => 'Giải đặc biệt', 1 => "Giải nhất"]+get_number_options(2, 8);
$request = request();
$orderby = $request->orderby;
$sorttype = $request->sorttype;

@endphp
@extends($_layout.'admin')
@section('title', 'Danh sách Loại hình cược')
@section('header_title', 'Loại hình cược')

@section('content')



                    <div class="ms-panel">
                        <div class="ms-panel-body">
                            {{-- @include($_template.'filter.default',[
                                'searchable' => [
                                    'name' => 'Tên'
                                ],
                                'sortable' => [
                                    'name' => 'Tên',
                                    'id' => 'ID',
                                    'created_at' => 'Thời gian tạo'
                                ],
                                
                            ]) --}}
                            {{-- @if (count($types)) --}}
                                
                            <div class="table-responsive">
                                <table class="table table-bordered thead-primary type-table smart-table smart-data-table" data-title="Loại cược"
                                    data-trash-url="{{route('admin.bettings.types.move-to-trash')}}"
                                    @if ($orderby)
                                        data-orderby=
                                    @endif
                                    >
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Tên Loại</th>
                                            <th scope="col" class="hide-xs">Loại cha</th>
                                            <th scope="col" class="hide-xs text-center">Giải</th>
                                            <th scope="col" class="hide-sm text-center">Số chữ số</th>
                                            <th scope="col" class="hide-sm text-center">Tổ hợp</th>
                                            <th scope="col" class="text-center">Tỷ lệ <span class="hide-sm text-white">mặc định</span></th>
                                            {{-- <th scope="col" class="hide-xs hide-sm text-center">Trạng thái</th> --}}
                                            <th scope="col" class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($types as $type)
                                            
                                        <tr id="smart-item-{{$type->id}}" class="smart-item" data-id="{{$type->id}}">
                                            <th scope="row">{{$type->id}}</th>
                                            <td class="name">
                                                <span class="d-sm-none">Tên</span>
                                                {{$type->name}}
                                                <div class="d-sm-none">
                                                    Loại cha: {{$type->parent?$type->parent->name:'Không'}}
                                                    <br>
                                                    Giải: {{$type->getJackpotOrderText()}}
                                                    <br>
                                                    Số chữ số: {{$type->number_length}}
                                                    <br>
                                                    Tổ hợp: {{$type->number_combine}}
                                                </div>
                                            </td>
                                            <td class="hide-xs">{{$type->parent?$type->parent->name:'Không'}}</td>
                                            <td class="hide-xs text-center">{{$type->getJackpotOrderText()}}</td>
                                            <td class="hide-sm text-center">{{$type->number_length}}</td>
                                            <td class="hide-xs hide-sm text-center">{{$type->number_combine}}</td>
                                            <td class="text-center">{{$type->default_rate}}</td>
                                            <td class="text-center">
                                                <a href="{{route('admin.bettings.types.update',['id' => $type->id])}}"><i class="fas fa-pencil-alt text-secondary"></i></a>
                                                <a class="btn-trash-item" href="#" data-id="{{$type->id}}"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                            </td>
                                            
                                        </tr>
                                        
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- {{$types->links($_template.'pagination')}}
                            @else
                                <div class="alert alert-danger text-center">Không có người dùng nào</div>
                            @endif --}}
                        </div>
                    </div>
@endsection



@section('js')
<script src="{{asset('assets/app/js/app.datatable.js')}}"></script>
    
@endsection