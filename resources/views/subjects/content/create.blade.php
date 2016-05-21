@extends('layouts.app')

@section('title')
	Add a new subject
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add a new subject</div>
				<div class="panel-body">
					{!! Form::open(['url' => '/subject-sections/']) !!}
						<div class="form-group">
							{!! Form::label('subject_title', 'Title:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('subject_title', null, ['class' => 'form-control', 'required']) !!}

								@if ($errors->has('subject_title'))
						            <span class="help-block">
						                <strong>{{ $errors->first('subject_title') }}</strong>
						            </span>
						        @endif
							</div>
						</div>

                        <div class="form-group{{ $errors->has('section_id') ? ' has-error' : '' }}">
                            {!! Form::label('section_id', 'Section', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::select('section_id', $sections, null, ['class' => 'form-control', 'placeholder' => 'Select from the following...']) !!}

                                @if ($errors->has('section_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('section_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                            {!! Form::label('user_id', 'Faculty', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::select('user_id', $facultyList, null, ['class' => 'form-control', 'placeholder' => 'Select from the following...']) !!}

                                @if ($errors->has('user_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group">
							{!! Form::label('sy', 'SY:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('sy', null, ['class' => 'form-control', 'required', 'maxlength' => '9']) !!}

								@if ($errors->has('sy'))
						            <span class="help-block">
						                <strong>{{ $errors->first('sy') }}</strong>
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
								{!! Form::submit('Add subject', ['class' => 'btn btn-primary form-control']) !!}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection