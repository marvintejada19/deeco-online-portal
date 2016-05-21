@extends('layouts.app')

@section('title')
    DEECO Online Portal
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="jumbotron">
                <h1>Welcome!</h1>
                <p><b>This is the official online learning portal of Dee Hwa Liong Academy.</b></p>
                <p><b>Click <a class="btn btn-primary btn-lg" href="/login" role="button">here</a>
                    to login and start.</b>
                </P>
            </div>
        </div>
    </div>
</div>
@endsection
