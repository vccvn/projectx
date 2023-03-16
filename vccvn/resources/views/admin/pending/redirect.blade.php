@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Đang chuyển hướng')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Redirect')

<?php 
$t = isset($time)?$time:5;
$u = isset($url)?$url:route('admin.dashboard');
?>

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <p>Sẽ chuyển tới: {{$u}}</p>
            <p>Sau <span class="redirect-time">{{$t}}</span> giây nữa</p>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var t = {{$t}};
        var f = function(){
            setTimeout(function () {
                t--;
                $('.redirect-time').html(t);
                if(t < 0){
                    top.location.href = '{{$u}}';
                    return;
                }
                f();
            }, 1000);
        };
        f();
            
    </script>
@endsection