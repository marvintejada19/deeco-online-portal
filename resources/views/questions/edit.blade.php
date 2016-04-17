@extends('layouts.app')

@section('title')
	Edit question
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit question</div>
				<div class="panel-body">
					{!! Form::model($question, ['method' => 'PATCH', 'url' => '/questions/' . $question->id]) !!}
						@include('questions.form', ['submitButtonText' => 'Edit question'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection