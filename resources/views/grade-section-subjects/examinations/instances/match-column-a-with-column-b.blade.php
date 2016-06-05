@extends('grade-section-subjects.examinations.instances.layout')

@section('instance-form')
<div class="panel panel-default">
	<div class="panel-heading">{!! $question->body !!}</div>
    <div class="panel-body">
    	<table class="table table-responsive">
    		<tr>
    			<td style="width:65%">
    				<ul class="list-group">
    				@foreach ($items as $item)
    					<li class="list-group-item">
    						<div class="form-group" id="item_div_{{ $item->id }}" onclick="setToActive({{ $item->id }})">
								<div class="input-group">
									<span class="input-group-addon">{{ $item->text }}</span>
									<label class="form-control" id="input_div_{{ $item->id }}">{{ $answers[$item->id] or '' }}</label>
									<span class="input-group-btn">
										<label class="btn" onclick="removeAnswer({{ $item->id }})">
											<span class="glyphicon glyphicon-chevron-right"></span>
										</label>
									</span>
									<input type="hidden" id="hidden_div_{{ $item->id }}" value="{{ $answerIds[$item->id] or '' }}" name="answers[{{ $item->id }}]">
								</div>
							</div>
						</li>
    				@endforeach
					</ul>
    			</td>

    			<td style="width:35%">
					<ul class="list-group">
    				@foreach ($choices as $choice)
    					<li class="list-group-item">
    						@if (in_array($choice->id, $answerIds))
    						<label class="btn btn-success form-control disabled" id="choice_div_{{ $choice->id }}" onclick="insertAnswer({{ $choice->id }}, '{{ $choice->text }}');">
								{{ $choice->text }}
							</label>
    						@else
    						<label class="btn btn-success form-control" id="choice_div_{{ $choice->id }}" onclick="insertAnswer({{ $choice->id }}, '{{ $choice->text }}');">
								{{ $choice->text }}
							</label>
							@endif
						</li>
    				@endforeach
					</ul>
    			</td>
    		</tr>
    	</table>
    </div>
</div>

<div class="form-group">
	<div class="col-md-6 col-md-offset-4">
		{!! Form::submit('Submit answers', ['class' => 'btn btn-primary form-control']) !!}
	</div>
</div>

<script type="text/javascript">
	var activeDiv = '';
	var activeId = '';

	function setToActive(itemId){
		activeDiv.className = "form-group";
		activeDiv = document.getElementById('item_div_' + itemId);
		activeDiv.className = "form-group has-success";
		activeId = itemId;
	}

	function insertAnswer(choiceId, answer){
		choiceDiv = document.getElementById('choice_div_' + choiceId);
		if (choiceDiv.className == 'btn btn-success form-control'){
			hiddenDiv = document.getElementById('hidden_div_' + activeId);
			if (hiddenDiv.value != ''){
				prevChoiceDiv = document.getElementById('choice_div_' + hiddenDiv.value);
				prevChoiceDiv.className = "btn btn-success form-control";
			}
			hiddenDiv.value = choiceId;
			labelDiv = document.getElementById('input_div_' + activeId);
			labelDiv.innerHTML = answer;

			deactivateOption(choiceId);
		}
	}

	function deactivateOption(choiceId){
		choiceDiv = document.getElementById('choice_div_' + choiceId);
		choiceDiv.className = "btn btn-success form-control disabled";
	}

	function removeAnswer(itemId){
		hiddenDiv = document.getElementById('hidden_div_' + itemId);
		choiceId = hiddenDiv.value;
		hiddenDiv.value = '';
		labelDiv = document.getElementById('input_div_' + itemId);
		labelDiv.innerHTML = '';

		activateOption(choiceId);
	}

	function activateOption(choiceId){
		choiceDiv = document.getElementById('choice_div_' + choiceId);
		choiceDiv.className = "btn btn-success form-control";
	}
</script>
@endsection