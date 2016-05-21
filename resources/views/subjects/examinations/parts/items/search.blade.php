<table class="table">
	{!! Form::open(['url' => 'subjects/' . $subject->id . '/examinations/' . $examination->id . '/parts/' . $part->id . '/items/create']) !!}	
	<tr>
		<th>Category</th>
		<th>Topic</th>
		<td></td>
	</tr>
	<tr>
		<td>
			<select name="category" id="category_ddl" onchange="configureTopicDropDownLists()" class="form-control" required>
				<option value="" disabled selected>Select from the following...</option>
				@foreach ($categories as $category)
					<option value="{{ $category->id }}">{{ $category->name }}</option>
				@endforeach
			</select>
		</td>
		<td>
			<select name="topic" id="topic_ddl" class="form-control">
				<option value="" disabled selected>Select from the following...</option>
			</select>
		</td>
		<td>
			<button type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-search"></span> Search
    		</button>
		</td>
	</tr>
	{!! Form::close() !!}
</table>