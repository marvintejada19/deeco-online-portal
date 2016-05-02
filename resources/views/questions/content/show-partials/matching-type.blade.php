@extends('questions.content.show')

@section('question-details')
<tr>
	<th>Type:</th>
	<td>{{ $question->getQuestionType() }} <span class="glyphicon glyphicon-th-list"></span></td>
</tr>

<tr>
	<th>Format:</th>
	<td>{{ $matchingType->format }}</td>
</tr>

<tr>
	<th>Choices:</th>
	<td>
		<table class="table table-bordered">
			<?php $count = 0; ?>
			<tr>
			@foreach ($choices as $choice)
				<?php 
					if ($count == 3){
						echo "</tr><tr>";
						$count = 0;
					}
				?>
				<td>
					@if (in_array($choice->text, $correctChoices))
						<font color="green">
					@else
						<font color="red">
					@endif
						{{ $choice->text }}
						</font>
				</td>
				<?php 
					$count++; 
				?>
			@endforeach
			</tr>
		</table>
	</td>
</tr>

<tr>
	<th>Items:</th>
	<td>
		<table class="table table-bordered">
			<tr>
				<th>Item</th>
				<th>Corresponding answer</th>
			</tr>
			@foreach ($items as $item)
			<tr>
				<td>{{ $item->text }}</td>
				<td>{{ $item->correct_answer }}</td>
			</tr>
			@endforeach
		</table>
	</td>
</tr>

@endsection