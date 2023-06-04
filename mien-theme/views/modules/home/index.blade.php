
@extends($_layout.'master')
@section('disable_footer', 1)
@section('content')
    <div class="home-page-content">

        {!! $html->home_area->components !!}
    </div>
@endsection