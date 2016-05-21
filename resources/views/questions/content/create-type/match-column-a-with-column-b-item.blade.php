@extends('layouts.app')

@section('title')
	Add a new item
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add a new item</div>
				<div class="panel-body">
					{!! Form::open(['url' => '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id . '/match-column-a-with-column-b/items']) !!}
						<div class="form-group">
							{!! Form::label('item', 'Text:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('item', null, ['class' => 'form-control', 'required', 'maxlength' => '255']) !!}
							</div>
						</div>

						<div class="form-group">
                            {!! Form::label('choice', 'Corresponding answer', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                            	{!! Form::text('choice', null, ['class' => 'form-control', 'required', 'maxlength' => '255']) !!}
                            </div>
                        </div>					

						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								<button type="button" class="btn btn-danger" 
									onclick="location.href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/{{ $question->id }}'">
									Back
								</button>
							</div>
						</div>

						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit('Add item', ['class' => 'btn btn-primary form-control']) !!}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection