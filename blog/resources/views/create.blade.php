<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body>
    <h1>{{ $title }}</h1>
<form action="../post" method="post">
{!!Form::token()!!}
<input type="text" name="title">
<input type="text" name="content">
<input type="submit">
</form>
</body>
</html>