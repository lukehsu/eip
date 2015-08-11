<?php namespace App\Http\Controllers;
use App\Post;
use Request;
use Input;
class TestController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */    
    public function index()
    {
    	$posts = Post::all();
    	return view('test')
        	->with('title', 'My Blog')
        	->with('posts', $posts)
        	->with('test', 'test');        	
    }


    public function edit($id)
    {

    $post = Post::find($id);

    return view('edit')
            ->with('title', '編輯文章')
            ->with('post', $post); 	
    }


    public function show($id)
	{
    	return view('test')
            ->with('title', '首頁')
            ->with('hello', '大家好～～'.$id);
	}


	public function create()
	{
    	return view('create')
            ->with('title', '新增文章');
	}


	public function update($id)
	{
    	$input = Input::all();

    	$post = Post::find($id);
    	$post->title = $input['title'];
    	$post->content = $input['content'];
    	$post->save();
	}


	public function destroy($id)
	{
    	$post = Post::find($id);
    	$post->delete();
	}

	
	public function store()
	{
    	$input = Input::all();
    	$post = new Post;
    	$post->title = $input['title'];
    	$post->content = $input['content'];
    	$post->save();
    	//return view('store')
        //    ->with('title', $input['title'] );
    	//$post = new Post;
    	//$post->title = $input['title'];
    	//$post->content = $input['content'];
    	//$post->save();

    	//return Redirect::to('post');
	}
}
