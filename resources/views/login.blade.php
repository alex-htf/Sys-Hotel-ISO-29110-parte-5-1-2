<!DOCTYPE html>
<html lang="en">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Sys-Hotel -- Inicio Sesión</title>

		<!-- Meta -->
		<meta name="description" content="Sistema de Recepción de Habitaciones para Hotel" />
		<meta name="author" content="Martín Avila" />
		<meta property="og:title" content="Sys Hotel">
		<meta property="og:description" content="Sistema de Recepción de Habitaciones para Hotel">
		<meta property="og:type" content="Website">
		<meta property="og:site_name" content="Sys-Hotel">
		<link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" />

		

		<!-- Bootstrap font icons css -->
		<link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css" />

		<!-- Main css -->
		<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />


	</head>

	<body>
		<!-- Container start -->
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-4 col-lg-5 col-sm-6 col-12">
					<form action="{{ url('login') }}" class="my-5" method="POST">
						@csrf
						<div class="border border-dark rounded-2 p-4 mt-5">
							<div class="login-form">
								<a href="index.html" class="mb-4 d-flex justify-content-center">
									<img src="{{ asset('assets/images/logo.jpeg')}}" class="img-fluid login-logo" alt="Nyke Admin" />
								</a>
								<h5 class="fw-light mb-5">Bienvenido, Por favor ingrese los datos para Acceder al Sistema.</h5>

								<div class="mb-3">
									<label class="form-label">Usuario:</label>
									<input type="text" class="form-control" name="LoginUsuario" placeholder="Ingresa el Usuario" />
								</div>
								<div class="mb-3">
									<label class="form-label">Contraseña:</label>
									<input type="password" class="form-control" name="LoginPassword" placeholder="Ingresa la Contraseña" />
								</div>

								
								<div class="d-grid py-3 mt-4">
									<button type="submit" class="btn btn-lg btn-primary">
										Ingresar
									</button>
								</div>

							</div>

							@if(Session::has('message'))
							<div class="container">
								@if(Session::has('success'))
									<div class="alert alert-success" style="display:none;">
								@else
									<div class="alert alert-danger" style="display:block;">
								@endif
								
									{{ Session::get('message') }}
									@if ($errors->any())
									<ul>
										@foreach($errors->all() as $error)
										<li>{{ $error }}</li>
										@endforeach
									</ul>
									@endif
								</div>
							</div>
							@endif

						</div>
					</form>

				


				</div>
			</div>
		</div>
		<!-- Container end -->
	</body>

</html>