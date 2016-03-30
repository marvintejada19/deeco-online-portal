@extends('layouts.app')

@section('title')
	Delete article
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete article</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'articles/' . $article->id . '/delete']) !!}
						<div class="form-group">
							{!! Form::label(null, 'Are you sure you want to delete this article?', ['class' => 'col-md-4 control-label']) !!}
							<blockquote>
								<article class="panel panel-default">
					                <div class="panel-heading">
					                    {{ $article->title }}
					                </div>
					                <div class="panel-body">
					                    {{ $article->body }}
					                </div>
					            </article>
							</blockquote>
							{!! Form::submit('Delete article', ['class' => 'btn btn-danger']) !!}
							<input class="btn btn-primary" type="button" onclick="location.href='/articles/list'" value="Back">
    					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection