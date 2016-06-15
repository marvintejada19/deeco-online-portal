@extends('layouts.app')

@section('title')
	Edit choice
@endsection

@section('content')
<div class="container">
	@include('flash::message')
    <div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit choice</div>
				<div class="panel-body">
					{!! Form::model($choice, ['url' => '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id . '/multiple-choice/choices/' . $choice->id]) !!}
						<div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
							@if ($choice->is_right_answer)
							{!! Form::label('text', 'Right answer:', ['class' => 'col-md-4 control-label']) !!}
							@else
							{!! Form::label('text', 'Wrong answer:', ['class' => 'col-md-4 control-label']) !!}
							@endif
							<div class="col-md-6">
							    {!! Form::textarea('text', null, ['class' => 'form-control']) !!}

							    @if ($errors->has('text'))
							        <span class="help-block">
							            <strong>{{ $errors->first('text') }}</strong>
							        </span>
							    @endif
							</div>
						</div>

						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								<button type="button" class="btn btn-danger" onclick="location.href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/{{ $question->id }}'">
									Back
								</button>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4 pull-right">
								{!! Form::submit('Update choice', ['class' => 'btn btn-primary form-control']) !!}
							</div>
						</div>
					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection