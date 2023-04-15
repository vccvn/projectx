

        <!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>

		<!--end::Web font -->

		<!--begin::Base Styles -->
		<link href="{{asset('static/manager/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="{{asset('static/manager/assets/vendors/base/vendors.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />-->
		<link href="{{asset('static/manager/assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="{{asset('static/manager/assets/demo/default/base/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />-->

		<!--end::Base Styles -->
        <link rel="shortcut icon" href="{{siteinfo('favicon', asset('static/manager/assets/demo/default/media/img/logo/favicon.ico'))}}" />
        
		<!-- my css -->

		<link rel="stylesheet" href="{{asset('static/fonts/fonts.css')}}" type="text/css">
		<link rel="stylesheet" href="{{asset('static/manager/css/style.min.css')}}" type="text/css">
		<link rel="stylesheet" href="{{asset('static/manager/css/color.min.css')}}" type="text/css">
		<link rel="stylesheet" href="{{asset('static/crazy/css/crazy.min.css')}}" type="text/css">

		<!-- css croppie -->
		<!-- <link rel="stylesheet" href="{{asset('static/cropie/croppie.css')}}" type="text/css"> -->
		<!-- <link rel="stylesheet" href="{{asset('static/cropie/bootstrap.min.css')}}" type="text/css"> -->


		{{-- <link rel="stylesheet" href="{{asset('static/css/custom.min.css')}}" type="text/css"> --}}


		
		@yield('css')
		
		@if ($css = get_custom_css())
			<style>
			{!! $css !!}
			</style>
		@endif

		@if ($links = get_css_link())
		
		@foreach ($links as $link)
		
		<link rel="stylesheet" href="{{$link}}">


		@endforeach
		@endif

