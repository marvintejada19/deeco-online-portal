@extends('layouts.app')

@section('title')
	Change password
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-heading">Change password</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'password/change']) !!}
						<div class="form-group{{ $errors->has('oldPassword') ? ' has-error' : '' }}">
							{!! Form::label('oldPassword', 'Old password:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								<input type="password" class="form-control" name="oldPassword"></input>
								
								@if ($errors->has('oldPassword'))
						            <span class="help-block">
						                <strong>{{ $errors->first('oldPassword') }}</strong>
						            </span>
						        @endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('newPassword') ? ' has-error' : '' }}">
							{!! Form::label('newPassword', 'New password:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('newPassword', null, ['class' => 'form-control', 'maxlength' => '255']) !!}

								@if ($errors->has('newPassword'))
						            <span class="help-block">
						                <strong>{{ $errors->first('newPassword') }}</strong>
						            </span>
						        @endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('newPassword_confirmation') ? ' has-error' : '' }}">
							{!! Form::label('newPassword_confirmation', 'Confirm new password:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('newPassword_confirmation', null, ['class' => 'form-control', 'maxlength' => '255']) !!}

								@if ($errors->has('newPassword_confirmation'))
						            <span class="help-block">
						                <strong>{{ $errors->first('newPassword_confirmation') }}</strong>
						            </span>
						        @endif
							</div>
						</div>

						<div class="form-group">
                            <div class="col-md-6 pull-right">
                                <input class="btn btn-default" type="button" onclick="generatePassword()" value="Generate Password">
                            </div>
                        </div>
                        <br></br>

						<div class="form-group pull-right">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit('Change Password', ['class' => 'btn btn-warning form-control']) !!}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function generatePassword(){
    var string = "<?php echo $randKey ?>";
    document.getElementById("newPassword").value = string;
    document.getElementById("newPassword_confirmation").value = string;
}
</script>
@endsection