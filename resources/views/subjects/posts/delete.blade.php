@extends('layouts.app')

@section('title')
	Delete subject post
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete subject post</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'subjects/' . $subject->id . '/posts/' . $post->id . '/delete']) !!}
						<div class="form-group">
							{!! Form::label(null, 'Are you sure you want to delete this post?', ['class' => 'col-md-4 control-label']) !!}
							<blockquote>
								<article class="panel panel-default">
					                <div class="panel-heading">
					                    {{ $post->title }}
					                </div>
					                <div class="panel-body">
					                    {{ $post->body }}
					                </div>
					            </article>
							</blockquote>
							{!! Form::submit('Delete post', ['class' => 'btn btn-danger']) !!}
							<input class="btn btn-primary" type="button" onclick="location.href='/subjects/{{ $subject->id }}'" value="Back">
    					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection