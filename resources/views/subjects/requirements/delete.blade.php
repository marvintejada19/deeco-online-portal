@extends('layouts.app')

@section('title')
	Delete subject requirement
@endsection

@section('content')
<div class="container">
	<button type="button" class="btn btn-default btn-sm" onclick="location.href='/subjects/{{ $subject->id }}'">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
    </button><hr/>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete subject requirement</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'subjects/' . $subject->id . '/requirements/' . $requirement->id . '/delete']) !!}
						<div class="form-group">
							{!! Form::label(null, 'Are you sure you want to delete this requirement?', ['class' => 'col-md-4 control-label']) !!}
							<blockquote>
								<article class="panel panel-default">
					                <div class="panel-heading">
					                    {{ $requirement->title }}
					                </div>
					                <div class="panel-body">
					                    {{ $requirement->body }}
					                </div>
					            </article>
							</blockquote>
							{!! Form::submit('Delete requirement', ['class' => 'btn btn-danger']) !!}
							<input class="btn btn-primary" type="button" onclick="location.href='/subjects/{{ $subject->id }}'" value="Back">
    					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection