<!DOCTYPE html>

<html lang="vi">

	<!-- begin::Head -->
	<head>
		@Include($_base.'_meta.info')
		
		<meta name="csrf-token" content="{{ csrf_token() }}" />

		<script>
			window.warning = function warning(params) {
				
			};
		</script>
		
		@Include($_template.'css')

		
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			
			@include($_component.'header')

			<!-- END: Header -->

			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

				<!-- BEGIN: Left Aside -->
				@include($_component.'sidebar')

				<!-- END: Left Aside -->
				<div class="m-grid__item m-grid__item--fluid m-wrapper">

					<!-- BEGIN: Subheader -->
					@include($_component.'subheader')

					<!-- END: Subheader -->


					<div class="m-content">
						@yield('content')
						@include($_template.'modals')
					</div>
				</div>
			</div>

			<!-- end:: Body -->

			<!-- begin::Footer -->
			@include($_component.'footer')

			

			
			<!-- end::Footer -->
		</div>

		<!-- end:: Page -->

		<!-- begin::Quick Sidebar -->
		@include($_component.'quick-sidebar')

		<!-- end::Quick Sidebar -->

		<!-- begin::Scroll Top -->
		@include($_component.'scroll-top')

		<!-- end::Scroll Top -->

		<!-- begin::Quick Nav -->
		@include($_component.'quick-nav')

		<!-- begin::Quick Nav -->
		@include($_template.'loading')

		<!--begin::Base Scripts -->
		@include($_template.'js')

		<!--end::Base Scripts -->
		
	</body>

	<!-- end::Body -->
</html>