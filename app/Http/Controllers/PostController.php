<?php
namespace App\Http\Controllers;

use App\Post;
use App\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response; 


class PostController extends Controller
{
	public function getDashboard(){	
		$posts = Post::orderBy('updated_at','desc')->get();

		return view('dashboard', ['posts' => $posts]);
	}


	public function postCreatePost(Request $request)
	{   //Validation 
		$this->validate($request, [
			'new-post-body' => 'required|max:1000'
			]);
		$post = new Post();
		$post->body = $request['new-post-body'];
		$message = 'Error! could not be created';
		if($request->user()->posts()->save($post))
			{ $message = 'Post Created';
			}
		return redirect()->route('dashboard')->with(['message' => $message]);
	}

	public function getDeletePost($post_id)
	{	
		$post = Post::where('id', $post_id)->first();
		if(Auth::user() != $post->user){
			return redirect()->back();
		}
		$post->delete();
		return redirect()->route('dashboard')->with(['message' => 'Successfully Deleted']);
	}

	public function postEditPost(Request $request)
	{
		$this->validate($request,[
			'body' => 'required'
		]);
		$post = Post::find($request['postId']);
		if(Auth::user() != $post->user){
			return redirect()->back();
		}
		$post->body = $request['body'];
		$post->update();
		return response()->json(['new_body' => $post->body],200);
	}
	public function postLikePost(Request $request)
	{
		
		$post_id = $request['postId'];
		$is_like = $request['isLike'] === 'true';
		$update = false;
		$post = Post::find($post_id);
		if(!$post){
			return null;
		}
		$user = Auth::user();
		$like = $user->likes()->where('post_id', $post_id)->first();
		if($like){
			$already_like = $like->like;
			$update = true;
			if($already_like == $is_like){
				$like->delete();
				return null;
			}
		}
		else{
			$like = new Like();
		}
		$like->like = $is_like;
		$like->user_id = $user->id;
		$like->post_id = $post->id;
		if($update){
			$like->update();
		}
		else{
			$like->save();
		}
		return null;

	}
} 