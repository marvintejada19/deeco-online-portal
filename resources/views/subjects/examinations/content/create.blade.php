@extends('layouts.app')

@section('title')
	Create new subject examination
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new subject examination</div>
				<div class="panel-body">
					{!! Form::model($examination = new \App\Models\Subjects\SubjectExamination, ['url' => 'subjects/' . $subject->id . '/examinations']) !!}
						@include('subjects.examinations.content.form', ['submitButtonText' => 'Create examination'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection