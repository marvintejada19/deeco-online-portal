@extends('layouts.app')

@section('title')
	Create new examination header
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new examination header</div>
				<div class="panel-body">
					{!! Form::model($examination = new \App\Models\Examinations\Examination, ['url' => '/examinations']) !!}
						@include('grade-section-subjects.examinations.content.form', ['submitButtonText' => 'Create examination header'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection