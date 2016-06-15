@extends('grade-section-subjects.examinations.instances.layout')

@section('instance-form')
<div class="panel panel-info">
	<div class="panel-heading">{!! $question->body !!}</div>
    <div class="panel-body">
    	<div class="well">
    		<table class="table">
    			<tr>
    				<?php $count = 0 ?>
    				@foreach ($choices as $choice)
						<?php 
							if ($count == 3){
								echo "</tr><tr>";
								$count = 0;
							}
						?>
						<td style="width:33%">
							<label class="btn btn-success form-control" onclick="insertAnswer('{{ $choice->text }}');">
								{{ $choice->text }}
							</label>
			    		</td>
						<?php $count++; ?>
					@endforeach
    			</tr>
    		</table>
    	</div>

    	@foreach ($items as $item)
			<div class="form-group" id="item_div_{{ $item->id }}" onclick="setToActive({{ $item->id }})">
				<div class="input-group">
					<span class="input-group-addon">{{ $item->text }}</span>
					<label class="form-control" id="input_div_{{ $item->id }}">{{ $answers[$item->id] or '' }}</label>
					<input type="hidden" id="hidden_div_{{ $item->id }}" value="{{ $answers[$item->id] or '' }}" name="answers[{{ $item->id }}]" required>
				</div>
			</div>
    	@endforeach
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

	function setToActive(divId){
		activeDiv.className = "form-group";
		activeDiv = document.getElementById('item_div_' + divId);
		activeDiv.className = "form-group has-success";
		activeId = divId;
	}

	function insertAnswer(answer){
		hiddenDiv = document.getElementById('hidden_div_' + activeId);
		hiddenDiv.value = answer;
		labelDiv = document.getElementById('input_div_' + activeId);
		labelDiv.innerHTML = answer;
	}
</script>
@endsection