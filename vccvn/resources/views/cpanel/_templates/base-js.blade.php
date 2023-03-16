        
		
		<script src="{{asset('static/manager/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('static/manager/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
		<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

		<script src="{{asset('static/manager/js/app.js')}}"></script>
		<script src="{{asset('static/manager/js/api.js')}}"></script>

		@include($_template.'js-src')

		@yield('js')

		
		@yield('custom_js')


		@if (($successSession = session('success')) || ($messageSession = session('message'))))
		<script>
			App.Swal.success(@json($successSession?$successSession:$messageSession));
		</script>
		@elseif ($errorSession = session('error'))
		<script>
			App.Swal.error(@json($errorSession));
		</script>
		@endif
