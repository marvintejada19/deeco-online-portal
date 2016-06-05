@extends('layouts.app')

@section('title')
	Edit requirement details
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit requirement details</div>
				<div class="panel-body">
					{!! Form::model($requirement, ['method' => 'PATCH', 'url' => '/requirements/' . $requirement->id, 'files'=>true]) !!}
						@include('grade-section-subjects.requirements.form', ['submitButtonText' => 'Edit requirement', 'filesButtonText' => 'Add additional files:'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection