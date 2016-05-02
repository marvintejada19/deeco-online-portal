@extends('layouts.app')

@section('title')
	Add a new question category
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add a new question category</div>
				<div class="panel-body">
					{!! Form::model($category = new \App\Models\Questions\QuestionCategory, ['url' => 'categories']) !!}
						@include('questions.categories.form', ['submitButtonText' => 'Add category'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection