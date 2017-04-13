	@extends('layouts.master')

	@section('content')
		 @include('includes.message-block')
		<section class="row new-post">
			<div class="col-md-6 col-md-offset-6">
				<header><h3>What is in your mind?</h3></header>	
				<form action="{{ route('post.create') }}" method="post">
					<div class="form-group">
						<textarea class="form-control" name="new-post-body" id="new-post" rows="5" placeholder="your post"></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Create Post</button>
					<input type="hidden" name="_token" value="{{ Session::token() }}">
				</form>
			</div>	
		</section>
		<section class="row posts">
			<div class="col-md-6 col-md-offset-6">
				<h3>What other People say...</h3>
			</div>
		</section>
		<section class="row posts">
			<div class="col-md-6 col-md-offset-6">
				
				@foreach($posts as $post)
				
				<h3>{{$post->user->first_name}}</h3>
				<article class="post" data-postid="{{ $post->id }}">
					<p>{{ $post->body }}</p> 
					<div class="info">
						Posted on {{$post->user->updated_at }}
						
					</div>
					<div class="interaction">
						<a href="#" class = "like">{{ Auth::user()->likes()->where('post_id',$post->id)->first() ? Auth::user()->likes()->where('post_id',$post->id)->first()->like == 1 ? 'Liked' : 'Like' :'Like' }}</a>|
						<a href="#" class="like">{{ Auth::user()->likes()->where('post_id',$post->id)->first() ? Auth::user()->likes()->where('post_id',$post->id)->first()->like == 0 ? 'Disliked' : 'Dislike' :'Dislike' }}</a>
						@if(Auth::user() == $post->user)|
						<!--<a href="#" id="post-edit" data-postid="{{$post->id}}">Edit</a> -->
						<a href="#" class="edit">Edit</a> |
						<a href="{{route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
						@endif
					</div>
				</article>

				@endforeach
				
			</div>
		</section>
		<section>
			
		</section>

	<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Edit Post</h4>
	      </div>
	      <div class="modal-body">
	        <form>
	        	<div class = "form-group">
	        		<label for="post-body">Edit this post</label>
	        		<textarea class = "form-control" name = "post-body" id="post-body" rows="5"></textarea>
	        	</div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
	      </div>
	    </div>
	  </div>       
	</div>

	<script>
		var token = '{{ Session::token() }}';
		var urlEdit = '{{ route('edit') }}';
		var urlLike = '{{ route('like') }}';
	</script>

@endsection