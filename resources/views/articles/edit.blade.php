@extends('layouts.app')

@section('title')
	Edit article
@endsection

@section('content')
<div class="container">
	<button type="button" class="btn btn-default btn-sm" onclick="location.href='/home'">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
    </button><hr/>	
    <div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit {!! $article->title !!}</div>
				<div class="panel-body">
					{!! Form::model($article, ['method' => 'PATCH', 'url' => 'articles/' . $article->id]) !!}
						@include('articles.form', ['submitButtonText' => 'Update Article'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@stop