@extends('layouts.app')

@section('title')
	Add a new question
@endsection

@section('content')
<div class="container">
	@include('flash::message')
    <div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add a new question ({{ $type }})</div>
				<div class="panel-body">
					{!! Form::model($question = new \App\Models\Questions\Question, ['url' => '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/create/' . $url_type]) !!}
						@include('questions.content.form')
						
						@yield('type-content')
						
						{!! Form::hidden('type', $type) !!}

						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								<button type="button" class="btn btn-danger" onclick="location.href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}'">
									Back
								</button>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4 pull-right">
								{!! Form::submit('Add question', ['class' => 'btn btn-primary form-control']) !!}
							</div>
						</div>
					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection