@extends('layouts.app')

@section('title')
    Examination results
@endsection

@section('content')
<div class="container">
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/examinations">All Examinations</a></li>
        <li><a href="/examinations/{{ $examination->id }}">{{ $examination->description }}</a></li>
        <li class="active">Results</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary well">
                <div class="panel-heading">
                    <h5>Results of {{ $examination->description }}</h5>
                </div>
                <table class="table table-responsive table-hover">
                    <tr>
                        <th>Subcategory:</th><td>{{ $examination->subcategory }}</td>
                    </tr>
                    <tr>
                        <th>Title:</th><td>{{ $examination->description }}</td>
                    </tr>
                    <tr>
                        <th>Score:</th>
                        <td>{{ $deploymentInstance->score }} / {{ $examination->computeTotalPoints() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection