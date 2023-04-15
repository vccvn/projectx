<!DOCTYPE html>

<html lang="vi">

	<!-- begin::Head -->
	<head>
		@Include($_base.'_meta.info')
		
		{{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}

		@Include($_template.'clean-css')

	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body>
			@yield('content')
		@include($_template.'loading')
		
		@include($_template.'clean-js')

		
	</body>

	<!-- end::Body -->
</html>