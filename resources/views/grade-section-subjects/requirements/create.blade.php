@extends('layouts.app')

@section('title')
	Create new requirement
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new requirement</div>
				<div class="panel-body">
					{!! Form::model($requirement = new \App\Models\PostsAndRequirements\Requirement, ['url' => '/requirements', 'files'=>true]) !!}
						@include('grade-section-subjects.requirements.form', ['submitButtonText' => 'Create requirement', 'filesButtonText' => 'Insert files:'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection