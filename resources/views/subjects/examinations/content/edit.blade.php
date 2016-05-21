@extends('layouts.app')

@section('title')
	Edit subject examination details
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit subject examination details</div>
				<div class="panel-body">
					{!! Form::model($examination, ['method' => 'PATCH', 'url' => 'subjects/' . $subject->id . '/examinations/' . $examination->id]) !!}
						@include('subjects.examinations.content.form', ['submitButtonText' => 'Edit examination'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection