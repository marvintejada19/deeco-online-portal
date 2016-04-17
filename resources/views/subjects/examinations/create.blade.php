@extends('layouts.app')

@section('title')
	Create new subject examination
@endsection

@section('content')
<div class="container">
	<button type="button" class="btn btn-default btn-sm" onclick="location.href='/subjects/{{ $subject->id }}'">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
    </button><hr/>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new subject examination</div>
				<div class="panel-body">
					{!! Form::model($examination = new \App\Models\SubjectExamination, ['url' => 'subjects/' . $subject->id . '/examinations', 'files'=>true]) !!}
						@include('subjects.examinations.form', ['submitButtonText' => 'Create examination', 'filesButtonText' => 'Insert files:'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection