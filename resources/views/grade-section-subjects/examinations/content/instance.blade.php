@extends('layouts.app')

@section('title')
    Examination instance
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/examinations">All examinations</a></li>
        <li><a href="/examinations/{{ $examination->id }}">{{ $examination->description }}</a></li>
        <li class="active">Examination instance</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Answer a sample generated examination
                </div>
                <table class="table table-striped">
                    <tr>
                        <th style="width:50%" colspan="2">Subcategory:</th><td style="width:50%"  colspan="2">{{ $examination->subcategory }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Description:</th><td colspan="2">{{ $examination->description }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Total points</th><td colspan="2">{{ $examination->computeTotalPoints() }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Created by:</th><td colspan="2">{{ $examination->faculty->getInfo()->lastname }}, {{ $examination->faculty->getInfo()->firstname }}</td>
                    </tr>
                    <tr>
                        <td style="width:75%" colspan="3"></td>
                        <td style="width:25%">
                            {!! Form::open(['url' => '/examinations/' . $examination->id . '/faculty/instances']) !!}
                                <button type="submit" class="btn btn-primary" {{ (count($examination->parts) == 0) ? 'disabled' : '' }}>
                                    Start examination
                                </button>
                            {!! Form::close() !!}
                        </td> 
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@stop