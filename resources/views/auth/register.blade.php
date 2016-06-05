@extends('layouts.app')

@section('title')
    Register
@endsection

@section('content')
<div class="container">
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Register</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                {!! Form::model($user = new \App\Models\User, ['url' => '/users']) !!}
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                        {!! Form::label('role_id', 'Role', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('role_id', $roles, null, ['class' => 'form-control', 'id' => 'role_id', 'placeholder' => 'Select from the following...', 'onchange' => 'showLRNField()']) !!}

                            @if ($errors->has('role_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('role_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Username</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="username" value="{{ old('username') }}">

                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input type="text" id="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Confirm Password</label>

                        <div class="col-md-6">
                            <input type="text" id="password_confirmation" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
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

                    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Lastname</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">

                            @if ($errors->has('lastname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Firstname</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">

                            @if ($errors->has('firstname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            <label class="radio-inline">
                                {!! Form::radio('gender', '1') !!} Male
                            </label>
                            <label class="radio-inline">
                                {!! Form::radio('gender', '0') !!} Female
                            </label>
                            @if ($errors->has('gender'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div id="lrnDiv" style="display:none">
                        <div class="form-group{{ $errors->has('lrnNumber') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">LRN</label>

                            <div class="col-md-6">
                                <input id="lrnField" pattern=".{12,}" type="text" class="form-control" maxlength="12" name="lrnNumber" required value="{{ old('lrnNumber') }}" disabled>

                                @if ($errors->has('lrnNumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lrnNumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>    

                    <div class="form-inline{{ $errors->has('idNumberPre')||$errors->has('idNumberPost') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            <label class="control-label">ID Number</label>&nbsp;&nbsp;&nbsp;
                            <input type="text" pattern=".{2,}" title="Requires 2 digits" class="form-control" name="idNumberPre" value="{{ old('idNumberPre') }}" maxlength="2" size="2"> - 
                            <input type="text" pattern=".{4,}" title="Requires 4 digits" class="form-control" name="idNumberPost" value="{{ old('idNumberPost') }}" maxlength="4" size="4">

                            @if ($errors->has('idNumberPre'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('idNumberPre') }}</strong>
                                </span>
                            @endif
                            @if ($errors->has('idNumberPost'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('idNumberPost') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 pull-right">
                            {!! Form::submit('Register user', ['class' => 'btn btn-primary form-control']) !!}
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
        document.getElementById("password").value = string;
        document.getElementById("password_confirmation").value = string;
    }

    function showLRNField(id){
        var lrnDiv = document.getElementById('lrnDiv');
        var lrnField = document.getElementById('lrnField');
        var role_id = document.getElementById('role_id').value;
        
        if (role_id == '4'){
            lrnDiv.style = "display:";
            lrnField.disabled = false;
        } else {
            lrnDiv.style = "display:none";
            lrnField.disabled = true;
        }
    }
</script>
@endsection
