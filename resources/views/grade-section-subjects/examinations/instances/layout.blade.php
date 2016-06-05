@extends('layouts.app')

@section('title')
	@if ($instancePart->instance->deployment == null)
	Sample generated examination
	@else
	{{ $instancePart->instance->deployment->examination->description }}
	@endif
@endsection

@section('content')
<div class="container">
	{!! $navbar !!}
	@include('flash::message')
	<hr/>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">
					{{ $instancePart->examinationPart->getQuestionType() }}: 
					@if (!strcmp($instancePart->examinationPart->getQuestionType(), 'Multiple Choice'))
						Select the correct answer from the following.
					@elseif (!strcmp($instancePart->examinationPart->getQuestionType(), 'True or False'))
						Choose whether or not the given statement is true.
					@elseif (!strcmp($instancePart->examinationPart->getQuestionType(), 'Fill in the Blanks'))
						Identify what is being asked.
					@elseif (!strcmp($instancePart->examinationPart->getQuestionType(), 'Match Column A with Column B'))
						Match the correct answer to each corresponding item.
					@elseif (!strcmp($instancePart->examinationPart->getQuestionType(), 'Select from the Wordbox'))
						Select from the wordbox which answer is most appropriate.
					@endif
				</div>
				
			</div>
			{!! Form::open(['url' => $submitUrl]) !!}
				@yield('instance-form')
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection