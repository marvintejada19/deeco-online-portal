@extends('layouts.app')

@section('title')
    Change user details
@endsection

@section('content')
<div class="container">
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Change user details</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Change user details</div>
                <div class="panel-body">
                {!! Form::open(['method' => 'PATCH', 'url' => '/users/' . $user->id]) !!}
                    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Lastname</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lastname" value="{{ $user->getInfo()->lastname }}" maxlength="255" required>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Firstname</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="firstname" value="{{ $user->getInfo()->firstname }}" maxlength="255" required>
                        </div>
                    </div>

                    <div class="form-inline{{ $errors->has('idNumberPre')||$errors->has('idNumberPost') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            <label class="control-label">ID Number</label>&nbsp;&nbsp;&nbsp;
                            <input type="text" pattern=".{2,}" title="Requires 2 digits" class="form-control" name="idNumberPre" value="{{ $idNumberParts[0] }}" maxlength="2" size="2" required> - 
                            <input type="text" pattern=".{4,}" title="Requires 4 digits" class="form-control" name="idNumberPost" value="{{ $idNumberParts[1] }}" maxlength="4" size="4" required>
                        
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

                    @if (!strcmp($user->getRole(), 'Student'))
                    <div class="form-group{{ $errors->has('lrnNumber') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">LRN</label>

                        <div class="col-md-6">
                            <input type="text" pattern=".{12,12}" title="Requires 12 digits" class="form-control" name="lrnNumber" value="{{ $user->getInfo()->lrnNumber }}" required>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <div class="col-md-6 pull-right">
                            {!! Form::submit('Update user details', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
