@extends('layouts.app')

@section('title')
	Create new subject requirement
@endsection

@section('content')
<div class="container">
	<button type="button" class="btn btn-default btn-sm" onclick="location.href='/subjects/{{ $subject->id }}'">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
    </button><hr/>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new subject requirement</div>
				<div class="panel-body">
					{!! Form::model($requirement = new \App\Models\SubjectRequirement, ['url' => 'subjects/' . $subject->id . '/requirements', 'files'=>true]) !!}
						@include('subjects.requirements.form', ['submitButtonText' => 'Create requirement', 'filesButtonText' => 'Insert files:'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection