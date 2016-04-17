@extends('layouts.app')

@section('title')
	Add a new question
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add a new question</div>
				<div class="panel-body">
					{!! Form::model($question = new \App\Models\Question, ['url' => 'questions/create']) !!}
						@include('questions.form', ['submitButtonText' => 'Add question'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection