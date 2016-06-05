@extends('questions.content.show')

@section('question-menu')
<div class="btn-group pull-right">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
		<li><a href="{{ $backUrl }}/questions/{{ $question->id }}/multiple-choice/choices/create">Add another incorrect choice</a></li>
    </ul>
</div>
<br></br>
@endsection

@section('question-details')
<tr>
	<th>Type:</th>
	<td>{{ $question->getQuestionType() }} <span class="glyphicon glyphicon-option-horizontal"></span></td>
</tr>

<tr>
	<th>Right answer:</th>
	<td class="success">{!! $rightAnswer !!}</td>
</tr>

<tr>
	<th>Wrong answers:</th>
	<td>
		<table class="table table-bordered table-responsive">
			<?php $count = 0; ?>
			<tr>
			@foreach ($wrongAnswers as $wrongAnswer)
				<?php 
					if ($count == 3){
						echo "</tr><tr>";
						$count = 0;
					}
				?>
				<td>
					@if (count($wrongAnswers) > 1)
						{!! Form::open(['url' => 'remove-question-choice/multiple-choice/' . $wrongAnswer->id]) !!}
						{!! $wrongAnswer->text !!}
						<button type="submit" class="btn btn-danger btn-xs pull-right">
							<span class="glyphicon glyphicon-remove"></span>
						</button>
						{!! Form::close() !!}
					@elseif (count($wrongAnswers) == 1)
						{!! $wrongAnswer->text !!}
					@endif
				</td>
				<?php 
					$count++; 
				?>
			@endforeach
			</tr>
		</table>
	</td>
</tr>

@endsection