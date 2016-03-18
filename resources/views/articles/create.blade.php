@extends('layouts.app')

@section('title')
	Create new article
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Write a new article</div>
				<div class="panel-body">
					{!! Form::model($article = new \App\Models\Article, ['url' => 'articles']) !!}
						@include('articles.form', ['submitButtonText' => 'Add Article'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection