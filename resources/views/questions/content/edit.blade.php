@extends('layouts.app')

@section('title')
	Edit question details
@endsection

@section('content')
<div class="container">
	@include('flash::message')
    <div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit question details</div>
				<div class="panel-body">
					{!! Form::model($question, ['method' => 'PATCH', 'url' => '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id]) !!}
						@include('questions.content.form')						
						
						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								<button type="button" class="btn btn-danger" onclick="location.href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/{{ $question->id }}'">
									Back
								</button>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4 pull-right">
								{!! Form::submit('Update question', ['class' => 'btn btn-primary form-control']) !!}
							</div>
						</div>
					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection