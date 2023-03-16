@if ($data = get_js_data())
    <script>
        @foreach($data as $name => $value)

        var {{$name}} = @json($value);

        @endforeach
    </script>
@endif