        <script src="{{ asset('static/manager/assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('static/manager/assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>



        <script src="{{ asset('static/manager/js/app.js') }}"></script>
        <script src="{{ asset('static/manager/js/api.js') }}"></script>
        <script src="{{ asset('static/app/js/modules/select.js') }}"></script>


        <script src="{{ asset('static/crazy/js/modal.js') }}"></script>

        <script src="{{ asset('static/manager/js/main.js') }}"></script>

        @include($_template.'js-data')

        @yield('jsinit')

        <!-- js croppie -->
        <!-- <script src="{{ asset('static/cropie/croppie.js') }}"></script> -->
        {{-- <script src="{{asset('cropie/bootstrap.min.js')}}"></script>
		<script src="{{asset('cropie/jquery.min.js')}}"></script> --}}



        <script src="{{ asset('static/manager/js/custom.js') }}"></script>

        @include($_template.'js-src')

        @yield('js')


        @yield('custom_js')

        @php
            $h = false;
            $l = ['success', 'alert', 'warning', 'error'];
            
        @endphp
        @foreach ($l as $m)
            @if ($successSession = session($m))
				@php
					$h = true;
				@endphp
                <script>
                    App.Swal.{{$m}}(@json($successSession));
                </script>
            @endif
        @endforeach

		@if (!$h && $successSession = session('message'))
		<script>
			App.Swal.alert(@json($successSession));
		</script>
		@endif