@extends('layouts.app')

@section('title')
    Finish examination
@endsection

@section('content')
<div class="container">
    {!! $navbar !!}
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5>Are you sure you want to finish your examination and get your results?</h5>
                </div>
                <table class="table">
                    <tr>
                        <td></td>
                        <td style="width:35%">
                            {!! Form::open(['url' => $nextUrl ]) !!}
                                {!! Form::submit('Finish', ['class' => 'btn btn-success form-control']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td style="width:35%">
                            <button type="button" class="btn btn-default form-control" onclick="location.href='{{ $startUrl }}'">
                                Go back to start
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection