<?php 
$request = request();

// $keyword = $request->search; 
$per_page = $request->per_page; 

$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];

$date = $request->date?$request->date:date('Y-m-d');

$tanle = $request->table;

$buttons = [
    'users' => [
        'text' => 'User',
        'icon' => 'user',
        'color' => 'info'
    ],
    'lottos' => [
        'text' => 'Lotto',
        'icon' => 'cube',
        'color' => 'success'
    ],
    'bettings' => [
        'text' => 'Cược',
        'icon' => 'gamepad',
        'color' => 'warning'
    ]
];

?>

        <div class="filter-block align-middle">
            <form action="" method="get" class="tool-form">
                <div class="form-group row mb-0">
                    <div class="col-12 col-sm-6 col-md-3 ">
                        <div class="input-group">
                            <input type="text" name="date" id="date-range" class="form-control date-picker" placeholder="Ngày tháng" data-format="yy-mm-dd" value="{{$date}}" autocomplete="off">
                            <div class="input-group-append">
                                <label for="date-range" class="mt-0 input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </label>
                            </div>
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
                    <div class="col-12 col-sm-6 col-md-7">
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter"></i> Xem
                            </button>
                            @if (!$table || !isset($buttons[$table]))
                                @foreach ($buttons as $key => $item)
                                    
                                    <button type="button" class="btn btn-{{$item['color']}} btn-backup" data-table="{{$key}}">
                                        <i class="fa fa-{{$item['icon']}}"></i> Backup {{$item['text']}}
                                    </button>
                                @endforeach
                            @else
                                @php
                                    $key = $table;
                                    $item[$table];
                                @endphp
    
                                <button type="button" class="btn btn-{{$item['color']}} btn-backup" data-table="{{$key}}">
                                    <i class="fa fa-{{$item['icon']}}"></i> Backup {{$item['text']}}
                                </button>

                            @endif

                        </div>
                    </div>
                </div>
            </form>
        </div>
    
