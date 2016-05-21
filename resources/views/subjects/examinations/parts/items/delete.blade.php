@extends('layouts.app')

@section('title')
	Delete examination part item
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete examination part item</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'subjects/' . $subject->id . '/examinations/' . $examination->id . '/parts/' . $part->id . '/items/' . $item->id . '/delete']) !!}
						<div class="form-group">
							{!! Form::label(null, 'Are you sure you want to delete this item?', ['class' => 'col-md-4 control-label']) !!}
							<blockquote>
								<table class="table table-bordered">
				                    <tr>
				                        <th>Category:</th>
				                        <td>{{ $item->questionSubtopic->questionTopic->questionCategory->name }}</td>
				                    </tr>
				                    <tr>
				                        <th>Topic:</th>
				                        <td>{{ $item->questionSubtopic->questionTopic->name }}</td>
				                    </tr>
				                    <tr>
				                        <th>Subtopic:</th>
				                        <td>{{ $item->questionSubtopic->name }}</td>
				                    </tr>
				                    <tr>
				                        <th>Quantity:</th>
				                        <td>{{ $item->quantity }}</td>
				                    </tr>
				                    <tr>
				                    </tr>
				                </table>
							</blockquote>
							{!! Form::submit('Delete item', ['class' => 'btn btn-danger']) !!}
							<input class="btn btn-primary" type="button" onclick="location.href='/subjects/{{ $subject->id }}/examinations/{{ $examination->id}}/parts/{{ $part->id }}'" value="Back">
    					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection