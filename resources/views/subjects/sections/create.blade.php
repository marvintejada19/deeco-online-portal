@extends('layouts.app')

@section('title')
	Add a new section
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add a new section</div>
				<div class="panel-body">
					{!! Form::open(['url' => '/subject-sections/sections']) !!}
						<div class="form-group">
							{!! Form::label('grade_level', 'Grade level:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('grade_level', null, ['class' => 'form-control', 'required']) !!}

								@if ($errors->has('grade_level'))
						            <span class="help-block">
						                <strong>{{ $errors->first('grade_level') }}</strong>
						            </span>
						        @endif
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('section_name', 'Section name:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('section_name', null, ['class' => 'form-control', 'required']) !!}

								@if ($errors->has('section_name'))
						            <span class="help-block">
						                <strong>{{ $errors->first('section_name') }}</strong>
						            </span>
						        @endif
							</div>
						</div>

						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								<button type="button" class="btn btn-danger" onclick="location.href='/subject-sections/'">
									Back
								</button>
							</div>
						</div>

						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit('Add section', ['class' => 'btn btn-primary form-control']) !!}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection