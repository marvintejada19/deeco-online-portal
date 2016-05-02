@extends('layouts.app')

@section('title')
	Edit question
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit question</div>
				<div class="panel-body">
					{!! Form::model($question, ['method' => 'PATCH', 'url' => '']) !!}
						@include('questions.content.form')
						
						@yield('type-content')

						<div class="form-group">
						    <div class="col-md-6 col-md-offset-4 pull-right">
						        {!! Form::submit('Edit question', ['class' => 'btn btn-primary form-control']) !!}
						    </div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection