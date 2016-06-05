@extends('layouts.app')

@section('title')
	Edit post details
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit post details</div>
				<div class="panel-body">
					{!! Form::model($post, ['method' => 'PATCH', 'url' => '/posts/' . $post->id, 'files'=>true]) !!}
						@include('grade-section-subjects.posts.form', ['submitButtonText' => 'Edit post', 'filesButtonText' => 'Add additional files:'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection