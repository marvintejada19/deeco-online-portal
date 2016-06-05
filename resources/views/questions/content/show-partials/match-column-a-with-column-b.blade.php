@extends('questions.content.show')

@section('question-menu')
<div class="btn-group pull-right">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
		<li><a href="{{ $backUrl }}/questions/{{ $question->id }}/match-column-a-with-column-b/items/create">Add another item</a></li>
    </ul>
</div>
<br></br>
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