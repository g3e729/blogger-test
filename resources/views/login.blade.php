<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Blogger - Login</title>
</head>
<body>
	<form class="col-sm-6" action="{{ route('login.store') }}" method="POST">
		{{ csrf_field() }}
		<input type="email" name="email">
		<input type="password" name="password">
		<button type="submit">Login</button>
	</form>
</body>
</html>