@if ($data = get_js_src())
    @foreach ($data as $src)

    <script src="{{$src}}"></script>
    <!-- {{$src}} -->
    @endforeach
@endif