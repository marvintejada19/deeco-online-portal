<div class="row">
	@if(empty($results))
		<div class="col-md-8 col-md-offset-2 well">
			No results found.
		</div>
	@else
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
            <div class="panel-heading">Results</div>	
				<table class="table table-hover table-striped table-condensed table-bordered">
					<tr>
						<th></th>
						<th>#</th>
						<th>Type</th>
						<th>Title</th>
						<th>Category</th>
						<th>Topic</th>
						<th>Subtopic</th>
						<th></th>
					</tr>
					@foreach ($results as $question)
					<tr class="{{ in_array($question->id, $questions_added) ? 'success' : '' }}">
						<td>
							@if (in_array($question->id, $questions_added))
								Added
							@else
								{!! Form::open(['url' => '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/questions/add/' . $question->id]) !!}
									<button type="submit" class="btn btn-primary btn-sm">
										<span class="glyphicon glyphicon-plus"></span> Add
	                    			</button>
								{!! Form::close() !!}
							@endif
						</td>
						<td>{{ $question->id }}</td>
						<td>
							@if (!strcmp($question->getQuestionType(), 'Multiple Choice'))
								<span class="glyphicon glyphicon-option-horizontal"></span>
							@elseif (!strcmp($question->getQuestionType(), 'True or False'))
								<span class="glyphicon glyphicon-adjust"></span>
							@elseif (!strcmp($question->getQuestionType(), 'Fill in the Blanks'))
								<span class="glyphicon glyphicon-question-sign"></span>
							@elseif (!strcmp($question->getQuestionType(), 'Matching Type'))
								<span class="glyphicon glyphicon-th-list"></span>
							@endif
						</td>
						<td>{{ $question->title }}</td>
						<td>{{ $question->questionSubtopic->questionTopic->questionCategory->name }}</td>
						<td>{{ $question->questionSubtopic->questionTopic->name }}</td>
						<td>{{ $question->questionSubtopic->name }}</td>
						<td><div class="dropdown">
					            <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					                <span class="caret"></span>
					            </button>
					            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel">
					                @if (in_array($question->id, $questions_added))
					                <li><a class="bg-danger" href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/questions/remove/{{ $question->id }}">Remove question</a></li>
					                <li class="divider"></li>
					                @endif
                                    <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/questions/{{ $question->id }}">View details</a></li>
					            </ul>
					        </div>
					    </td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	@endif
</div>
