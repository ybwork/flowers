<!DOCTYPE html>
<html>
<head>
	<title>Cart</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-theme.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/fonts/font-awesome/css/font-awesome.min.css') }}">
	<link href="{{ asset('/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
</head>

	@include('site.sidebar')

	@yield('content')

	<script type="text/javascript" src="{{ asset('/js/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('/plugins/select2/dist/js/select2.min.js') }} " type="text/javascript"></script>
	<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
	<script type="text/javascript">
	$(".js-example-basic-multiple").select2();
	</script>
</body>
</html>