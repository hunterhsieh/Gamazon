<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Gamazon</title>

	<!-- Bootstrap core CSS -->
	<link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="{{asset('css/heroic-features.css')}}" rel="stylesheet">

</head>

<body>
@include('includes.header');
<div class="container">

	<div class="text-center">
		<div class="center">
			<h1 id="title">Sign Up</h1>
			<hr>
			<section>
				{!! Form::open(array('url'=>'/register/finish'))!!}<br>
				{!!Form::hidden('type','gamer')!!}
				{!!Form::label('name','*Name')!!}
				{!!Form::text('name')!!}<br><br>

				{!!Form::label('email','*Email')!!}
				{!!Form::text('email')!!}<br><br>


				{!!Form::label('password','*Password')!!}
				{!!Form::password('password')!!}<br><br>

				{!!Form::submit('Sign Up')!!}
				{!!Form::close()!!}<br>
			</section>
		</div>
	</div>
</div>

@include('includes.footer');

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>