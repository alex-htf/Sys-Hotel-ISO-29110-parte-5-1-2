<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="routeName" content="{{ Route::currentRouteName() }}">
		<meta name="app-url" content="{{ url('/') }}">
		<title>Sys Hotel -- Panel de administración</title>

		<!-- Meta -->
		<meta name="description" content="Sistema de Recepción de Habitaciones para Hotel" />
		<meta name="author" content="Martín Avila" />
		<meta property="og:title" content="Sys Hotel">
		<meta property="og:description" content="Sistema de Recepción de Habitaciones para Hotel">
		<meta property="og:type" content="Website">
		<meta property="og:site_name" content="Sys-Hotel">
		<link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" />

		<!-- *************
			************ CSS Files *************
		************* -->
		<link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
		<link href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">


		<!-- *************
			************ Vendor Css Files *************
		************ -->

		<!-- Scrollbar CSS -->
		<link rel="stylesheet" href="{{ asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}" />
	</head>

	<body>
		<!-- Page wrapper start -->
		<div class="page-wrapper">

			<!-- Main container start -->
			<div class="main-container">

				@include('sidebar')

				<!-- App container starts -->
				<div class="app-container">

					@include('header')

					@section('content')
        			@show

					@include('footer')

				</div>
				<!-- App container ends -->

			</div>
			<!-- Main container end -->

		</div>
		<!-- Page wrapper end -->

		<!-- *************
			************ JavaScript Files *************
		************* -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

		<!-- *************
			************ Vendor Js Files *************
		************* -->

		<!-- Overlay Scroll JS -->
		<script src="{{ asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
		<script src="{{ asset('assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>

		<!-- Apex Charts -->
		<script src="{{ asset('assets/vendor/apex/apexcharts.min.js') }}"></script>
		<script src="{{ asset('assets/vendor/apex/custom/dash1/sparkline.js') }}"></script>
		<script src="{{ asset('assets/vendor/apex/custom/dash1/customers.js') }}"></script>
		<script src="{{ asset('assets/vendor/apex/custom/dash1/channel.js') }}"></script>
		<script src="{{ asset('assets/vendor/apex/custom/dash1/deals.js') }}"></script>
		<script src="{{ asset('assets/vendor/apex/custom/dash1/demography.js') }}"></script>
		<script src="{{ asset('assets/vendor/apex/custom/dash1/device.js') }}"></script>
		<script src="{{ asset('assets/vendor/apex/custom/dash1/weekly-sales.js') }}"></script>

		<!-- Vector Maps -->
		<script src="{{ asset('assets/vendor/jvectormap/jquery-jvectormap-2.0.5.min.js') }}"></script>
		<script src="{{ asset('assets/vendor/jvectormap/world-mill-en.js') }}"></script>
		<script src="{{ asset('assets/vendor/jvectormap/gdp-data.js') }}"></script>
		<script src="{{ asset('assets/vendor/jvectormap/continents-mill.js') }}"></script>
		<script src="{{ asset('assets/vendor/jvectormap/custom/world-map-markers2.js') }}"></script>

		<!-- Custom JS files -->
		<script src="{{ asset('assets/js/custom.js') }}"></script>

		
		<script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>

		@section('scripts')
    	@show
	</body>

</html>