@extends('questions.content.show')

@section('question-menu')
<li class="divider"></li>
<li><a href="{{ $backUrl }}/questions/{{ $question->id }}/match-column-a-with-column-b/items/create">Add another item</a></li>
@endsection

@section('question-details')
<tr>
	<th>Type:</th>
	<td>{{ $question->getQuestionType() }} <span class="glyphicon glyphicon-th-list"></span></td>
</tr>

<tr>
	<th>Items:</th>
	@if ($choices->isEmpty())
	<td class="bg-danger">
		No items added yet.
	</td>
	@else
	<td>
		<table class="table table-bordered">
			<tr>
				<th>Item</th>
				<th>Corresponding answer</th>
			</tr>
			@foreach ($choices as $choice)
				<tr>
					<td>{{ $choice->item->text }}</td>
					<td>{{ $choice->text }}</td>
				</tr>
			@endforeach
		</table>
	</td>
	@endif
</tr>

@endsection