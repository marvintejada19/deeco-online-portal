@extends('questions.content.show')

@section('question-menu')
<li class="divider"></li>
<li><a href="{{ $backUrl }}/questions/{{ $question->id }}/select-from-the-wordbox/choices/create">Add another choice</a></li>
<li><a href="{{ $backUrl }}/questions/{{ $question->id }}/select-from-the-wordbox/items/create">Add another item</a></li>
@endsection

@section('question-details')
<tr>
	<th>Type:</th>
	<td>{{ $question->getQuestionType() }} <span class="glyphicon glyphicon-unchecked"></span></td>
</tr>

<tr>
	<th>Choices:</th>
	@if ($choices->isEmpty())
	<td class="bg-danger">
		No choices added yet.
	</td>
	@else
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
				<td>{{ $choice->text }}</td>
				<?php $count++;	?>
			@endforeach
			</tr>
		</table>
	</td>
	@endif
</tr>

<tr>
	<th>Items:</th>
	@if ($noItems)
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
			@foreach ($items as $item_collection)
				@unless ($item_collection->isEmpty())				
					@foreach ($item_collection as $item)
					<tr>
						<td>{{ $item->text }}</td>
						<td>{{ $item->choice->text }}</td>
					</tr>
					@endforeach
				@endunless
			@endforeach
		</table>
	</td>
	@endif
</tr>

@endsection