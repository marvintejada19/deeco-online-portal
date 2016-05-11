@extends('questions.content.instances.layout')

@section('instance-form')
	<div class="form-group">
		<div class="panel panel-primary text-center">
			<table class="table table-bordered table-responsive">
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
						{{ $choice }}
					</td>
					<?php 
						$count++; 
					?>
				@endforeach
				</tr>
			</table>
		</div>
	</div>

	<div class="form-group">
		<?php $count = 1; ?>
		@foreach ($items as $item)
			<div class="input-group">
				<span class="input-group-addon">{{ $count }}. &nbsp;{{ $item->text }}</span>
				<input type="text" value="{{ (array_key_exists($item->id, $answers)) ? $answers[$item->id] : '' }}" class="form-control" name="answers[{{$item->id}}]" required>
			</div>
			<?php $count++?>
		@endforeach
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4 pull-right">
			{!! Form::submit('Submit answer', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
@endsection