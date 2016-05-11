@extends('questions.content.instances.layout')

@section('instance-form')
	<div class="row">
		<div class="col-xs-6 col-md-4">
			<table class="table table-responsive">
				<?php $count = 1; ?>
				@foreach ($items as $item)
				<tr>
					<td>
					<div class="input-group">
						<span class="input-group-addon">{{ $count }}. &nbsp;&nbsp;{{ $item->text }}</span>
						<input type="text" value="{{ (array_key_exists($item->id, $answers)) ? $answers[$item->id] : '' }}" class="form-control" name="answers[{{$item->id}}]" required>
					</div>
					</td>
					<?php $count++?>
				</tr>
				@endforeach
			</table>
		</div>

		<div class="col-xs-6 col-md-4">
			<table class="table table-striped">
				@foreach ($choices as $choice)
					<tr><td>
						<span class="glyphicon glyphicon-stop"></span> &nbsp;&nbsp;&nbsp;{{ $choice }}
					</td></tr>
				@endforeach
			</table>
		</div>
	</div>

	<div class="col-md-1">
		{!! Form::submit('Submit answers', ['class' => 'btn btn-primary form-control']) !!}
	</div>
@endsection