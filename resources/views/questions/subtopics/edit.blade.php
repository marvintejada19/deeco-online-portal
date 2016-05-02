@extends('layouts.app')

@section('title')
	Edit question subtopic
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit question subtopic</div>
				<div class="panel-body">
					{!! Form::model($subtopic, ['method' => 'PATCH', 'url' => 'categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name]) !!}
						@include('questions.subtopics.form', ['submitButtonText' => 'Edit subtopic'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection