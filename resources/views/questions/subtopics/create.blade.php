@extends('layouts.app')

@section('title')
	Add a new question subtopic
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add a new question subtopic</div>
				<div class="panel-body">
					{!! Form::model($subtopic = new \App\Models\Questions\QuestionSubtopic, ['url' => 'categories/' . $category->name . '/topics/' . $topic->name . '/subtopics']) !!}
						@include('questions.subtopics.form', ['submitButtonText' => 'Add subtopic'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection