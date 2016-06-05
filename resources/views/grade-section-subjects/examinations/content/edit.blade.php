@extends('layouts.app')

@section('title')
	Edit examination header
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit examination header</div>
				<div class="panel-body">
					{!! Form::model($examination, ['method' => 'PATCH', 'url' => '/examinations/' . $examination->id]) !!}
						@include('grade-section-subjects.examinations.content.form', ['submitButtonText' => 'Edit examination header'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection