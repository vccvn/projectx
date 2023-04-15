@php
    $n = isset($name)?$name:'radio';
    $d = isset($data)?(is_array($data)?$data:(is_callable($data)?$data():[])):[];
    $v = $value??null;
@endphp

<ul class="ms-list d-flex">
    @foreach ($d as $vl => $text)
        
    <li class="ms-list-item pl-0">
        <label class="ms-checkbox-wrap">
            <input type="radio" name="{{$n}}" value="{{$vl}}" {{$vl==$v?'checked':''}}> <i class="ms-checkbox-check"></i>
            
        </label> 
        <span> {{$text}} </span>
    </li>
    
    @endforeach
</ul>