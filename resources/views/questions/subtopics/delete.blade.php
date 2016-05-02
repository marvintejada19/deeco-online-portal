@extends('layouts.app')

@section('title')
	Delete subtopic
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete subtopic</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/delete']) !!}
						<div class="form-group">
							{!! Form::label(null, 'Are you sure you want to delete this subtopic?', ['class' => 'col-md-4 control-label']) !!}
							<blockquote>
								<div class="panel panel-default">
					                <div class="panel-heading">
					                    {{ $subtopic->name }}
					                </div>
					            </div>
							</blockquote>
    					</div>
						<div class="form-group">
							<label class="well">All questions will be moved to the 'Default Subtopic' of {{ $topic->name}}</label>
						</div>
						{!! Form::submit('Delete subtopic', ['class' => 'btn btn-danger']) !!}
						<input class="btn btn-primary" type="button" onclick="location.href='/categories/{{ $category->name }}/topics/{{ $topic->name }}'" value="Back">
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection