

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

