@extends('layouts.app')

@section('title')
	Add a new question topic
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add a new question topic</div>
				<div class="panel-body">
					{!! Form::model($topic = new \App\Models\Questions\QuestionTopic, ['url' => 'categories/' . $category->name . '/topics/']) !!}
						@include('questions.topics.form', ['submitButtonText' => 'Add topic'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection