@extends('questions.content.show')

@section('question-details')
<tr>
	<th>Type:</th>
	<td>{{ $question->getQuestionType() }} <span class="glyphicon glyphicon-option-horizontal"></span></td>
</tr>

<tr>
	<th>Right answer:</th>
	<td class="success">{{ $rightAnswer }}</td>
</tr>

<tr>
	<th>Wrong answers:</th>
	<td>
		<table class="table table-bordered">
			<?php $count = 0; ?>
			<tr>
			@foreach ($wrongAnswers as $wrongAnswer)
				<?php 
					if ($count == 3){
						echo "</tr><tr>";
						$count = 0;
					}
				?>
				<td>{{ $wrongAnswer->text }}</td>
				<?php 
					$count++; 
				?>
			@endforeach
			</tr>
		</table>
	</td>
</tr>

@endsection