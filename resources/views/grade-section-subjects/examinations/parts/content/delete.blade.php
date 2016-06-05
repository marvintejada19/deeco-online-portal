@extends('layouts.app')

@section('title')
	Delete examination part
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete examination part</div>
				<div class="panel-body">
					{!! Form::open(['url' => '/examinations/' . $examination->id . '/parts/' . $part->id . '/delete']) !!}
						<div class="form-group">
							{!! Form::label(null, 'Are you sure you want to delete this part?', ['class' => 'col-md-4 control-label']) !!}
							<blockquote>
								<article class="panel panel-default">
					                <div class="panel-heading">
					                    Question type: {{ $part->getQuestionType() }}
					                </div>
					                <div class="panel-body">
					                    Points: {!! $part->points !!}
					                    <br>
					                    Total no. of questions: {!! $part->questions_quantity !!}
					                </div>
					            </article>
							</blockquote>
							{!! Form::submit('Delete part', ['class' => 'btn btn-danger']) !!}
							<input class="btn btn-primary" type="button" onclick="location.href='/examinations/{{ $examination->id}}/parts'" value="Back">
    					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection