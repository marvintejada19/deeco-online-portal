@extends('layouts.app')

@section('title')
	Edit examination part details
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit examination part details</div>
				<div class="panel-body">
					{!! Form::model($part, ['method' => 'PATCH', 'url' => '/examinations/' . $examination->id . '/parts/' . $part->id]) !!}
						@include('grade-section-subjects.examinations.parts.content.form', ['submitButtonText' => 'Edit part details'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection