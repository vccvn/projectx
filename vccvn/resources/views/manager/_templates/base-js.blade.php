        
		
		<script src="{{asset('static/manager/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('static/manager/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>


		@include($_template.'js-src')

		@yield('js')

		
		@yield('custom_js')

