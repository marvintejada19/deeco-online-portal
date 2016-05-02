@extends('layouts.app')

@section('title')
	Edit question category
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit question category</div>
				<div class="panel-body">
					{!! Form::model($category, ['method' => 'PATCH', 'url' => 'categories/' . $category->name]) !!}
						@include('questions.categories.form', ['submitButtonText' => 'Edit category'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection