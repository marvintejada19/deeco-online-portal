@extends('layouts.app')

@section('title')
	Edit subject requirement
@endsection

@section('content')
<div class="container">
	<button type="button" class="btn btn-default btn-sm" onclick="location.href='/subjects/{{ $subject->id }}'">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
    </button><hr/>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit subject requirement</div>
				<div class="panel-body">
					{!! Form::model($requirement, ['method' => 'PATCH', 'url' => 'subjects/' . $subject->id . '/requirements/' . $requirement->id, 'files'=>true]) !!}
						@include('subjects.requirements.form', ['submitButtonText' => 'Edit requirement', 'filesButtonText' => 'Add additional files:'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection