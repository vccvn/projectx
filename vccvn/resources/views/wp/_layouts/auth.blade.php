<!DOCTYPE html>

<html lang="vi">

	<!-- begin::Head -->
	<head>
		@Include($_base.'_meta.info')
		
		<meta name="csrf-token" content="{{ csrf_token() }}" />

		@Include($_template.'css')

	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			@yield('content')
			<!-- begin::Quick Nav -->
			
			@include($_template.'modals')
		</div>
		@include($_template.'loading')		
		<!--begin::Base Scripts -->
		@include($_template.'js')

		<!--end::Base Scripts -->
		
	</body>

	<!-- end::Body -->
</html>