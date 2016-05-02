@extends('layouts.app')

@section('title')
	Edit subject post
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit subject post</div>
				<div class="panel-body">
					{!! Form::model($post, ['method' => 'PATCH', 'url' => 'subjects/' . $subject->id . '/posts/' . $post->id, 'files'=>true]) !!}
						@include('subjects.posts.form', ['submitButtonText' => 'Edit post', 'filesButtonText' => 'Add additional files:'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection