@extends('layouts.app')

@section('title')
	Edit question topic
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit question topic</div>
				<div class="panel-body">
					{!! Form::model($topic, ['method' => 'PATCH', 'url' => 'categories/' . $category->name . '/topics/' . $topic->name]) !!}
						@include('questions.topics.form', ['submitButtonText' => 'Edit topic'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection