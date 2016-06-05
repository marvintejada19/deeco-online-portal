@extends('layouts.app')

@section('title')
	Create a new subject
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new subject</div>
				<div class="panel-body">
					{!! Form::open(['url' => '/others/subjects']) !!}
						<div class="form-group">
							{!! Form::label('name', 'Name:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
							</div>
						</div>

						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								<button type="button" class="btn btn-danger" onclick="location.href='/home'">
									Back
								</button>
							</div>
						</div>

						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit('Create subject', ['class' => 'btn btn-primary form-control']) !!}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection