@extends('layouts.app')

@section('title')
    TEMP
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    {!! Form::open(array('url'=>'upload','method'=>'POST', 'files'=>true)) !!}
                        {!! Form::file('files[]') !!}

                        {!! Form::submit('Upload', ['class'=>'send-btn']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
