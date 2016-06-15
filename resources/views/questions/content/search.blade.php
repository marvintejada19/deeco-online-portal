<table class="table">
	{!! Form::open(['url' => '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id . '/move']) !!}	
	<tr>
		<th>Category</th>
		<th>Topic</th>
		<td style="width:25%"></td>
	</tr>
	<tr>
		<td>
			@if ($selectedCategory)
				{{ $selectedCategory->name }}
			@else
			<select name="category" id="category_ddl" onchange="configureTopicDropDownLists()" class="form-control" required>
				<option value="" disabled selected>Select from the following...</option>
				@foreach ($categories as $category)
					<option value="{{ $category->id }}">{{ $category->name }}</option>
				@endforeach
			</select>
			@endif
		</td>
		<td>
			@if ($selectedTopic)
				{{ $selectedTopic->name }}
			@else
			<select name="topic" id="topic_ddl" class="form-control">
				<option value="" disabled selected>Select from the following...</option>
			</select>
			@endif
		</td>
		<td>
			@if ($selectedTopic == null)
			<button type="submit" class="btn btn-primary form-control">
				<span class="glyphicon glyphicon-search"></span> Search
    		</button>
    		@else
    		<label onclick='location.href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/{{ $question->id }}/move"' class="btn btn-warning form-control">
				<span class="glyphicon glyphicon-repeat"></span> Reset search
    		</label>
    		@endunless
		</td>
	</tr>
	{!! Form::close() !!}
</table>