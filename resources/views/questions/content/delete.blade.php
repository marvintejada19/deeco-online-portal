@extends('layouts.app')

@section('title')
	Delete question
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete question</div>
				<div class="panel-body">
					{!! Form::open(['url' => '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id . '/delete']) !!}
						<div class="form-group">
							{!! Form::label(null, 'Are you sure you want to delete this question?', ['class' => 'col-md-4 control-label']) !!}
							<blockquote>
								<article class="panel panel-default">
					                <div class="panel-heading">
					                    {{ $question->title }}
					                </div>
					                <div class="panel-body">
					                    {!! $question->body !!}
					                </div>
					            </article>
							</blockquote>
							{!! Form::submit('Delete question', ['class' => 'btn btn-danger']) !!}
							<input class="btn btn-primary" type="button" onclick="location.href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}'" value="Back">
    					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection