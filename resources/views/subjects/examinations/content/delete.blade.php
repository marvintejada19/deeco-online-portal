@extends('layouts.app')

@section('title')
	Delete subject examination
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete subject examination</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'subjects/' . $subject->id . '/examinations/' . $examination->id . '/delete']) !!}
						<div class="form-group">
							{!! Form::label(null, 'Are you sure you want to delete this examination?', ['class' => 'col-md-4 control-label']) !!}
							<blockquote>
								<div class="panel panel-default">
					                <div class="panel-heading">
					                    {{ $examination->title }}
					                </div>
					                <table class="table">
					                	<tr>
					                		<td>Total points:</td>
					                		<td>{{ $examination->total_points }}</td>
					                	</tr>
					                	<tr>
					                		<td>No. of questions:</td>
					                		<td>{{ count($examination->questions) }}</td>
					                	</tr>
					                </table>
					            </div>
							</blockquote>
							{!! Form::submit('Delete examination', ['class' => 'btn btn-danger']) !!}
							<input class="btn btn-primary" type="button" onclick="location.href='/subjects/{{ $subject->id }}/examinations'" value="Back">
    					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection