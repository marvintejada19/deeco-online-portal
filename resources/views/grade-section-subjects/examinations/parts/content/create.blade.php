@extends('layouts.app')

@section('title')
	Create new examination part
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create new examination part</div>
				<div class="panel-body">
					{!! Form::model($part = new \App\Models\Examinations\ExaminationPart, ['url' => '/examinations/' . $examination->id . '/parts']) !!}
						@include('grade-section-subjects.examinations.parts.content.form', ['submitButtonText' => 'Add part'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection