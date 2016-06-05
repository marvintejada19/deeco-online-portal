@extends('layouts.app')

@section('title')
    {{ $examination->description }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title}}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations">All examinations</a></li>
        <li class="active">{{ $examination->description }}</li>
    </ol>
    <br></br><hr/>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/parts">View all examination parts</a></li>
            <li class="divider">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/edit">Edit examination details</a></li>
            <li class="divider">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/instances">Generate sample exam</a></li>
            <li class="divider">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/student-results">View student examinations</a></li>
            <li class="divider">
            <li><a class="bg-info" href="/categories/subjects/{{ $subject->id }}">View all categories</a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    @if (!$examination->is_published)
                    {!! Form::open(['url' => '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/publish']) !!}
                        Status: {!! $status !!}
                        <button type="submit" class="btn btn-success pull-right">
                            Publish examination
                        </button>
                        <br></br>
                    {!! Form::close() !!}
                    @else
                        Status: {!! $status !!}
                    @endif
                </div>   
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Examination details
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Subcategory:</th><td>{{ $examination->subcategory }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th><td>{{ $examination->description }}</td>
                    </tr>
                    <tr>
                        <th>Total points</th><td>{{ $examination->computeTotalPoints() }}</td>
                    </tr>
                    <tr>
                        <th>Available from:</th><td>{{ $examination->getUnformattedDate('exam_start') }}</td>
                    </tr>
                    <tr>
                        <th>Available until:</th><td>{{ $examination->getUnformattedDate('exam_end') }}</td>
                    </tr>
                    <tr>
                        <th>Created at:</th><td>{{ $examination->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@stop