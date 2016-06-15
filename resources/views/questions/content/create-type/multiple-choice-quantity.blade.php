@extends('layouts.app')

@section('title')
	Specify number of choices
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Specify number of choices</div>
				<div class="panel-body">
					{!! Form::open(['url' => '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/create/' . $url_type . '/step-2/']) !!}
						<div class="form-group">
							{!! Form::label('quantity', 'Specify number of choices:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::number('quantity', 2, ['min' => '2', 'class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								<button type="button" class="btn btn-danger" 
									onclick="location.href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}'">
									Back
								</button>
							</div>
						</div>

						
						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit('Proceed to next step', ['class' => 'btn btn-primary form-control']) !!}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection