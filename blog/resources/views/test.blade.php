<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
</head>
<body>
    {!!link_to('post/create',$test)!!}
    <br>
	@foreach ( $posts as $post)
		{!!$post->title !!}  ({!!link_to('post/edit/'.$post->id,'編輯1') !!}) {!!$test!!}<br>
	@endforeach	
</body>
</html>