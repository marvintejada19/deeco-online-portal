@extends('layouts.app')

@section('title')
	Create new subject post
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new subject post</div>
				<div class="panel-body">
					{!! Form::model($post = new \App\Models\SubjectPost, ['url' => URL::previous() . '/posts', 'files'=>true]) !!}
						@include('subjects.posts.form', ['submitButtonText' => 'Create post'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection