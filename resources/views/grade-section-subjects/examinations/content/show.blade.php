@extends('layouts.app')

@section('title')
    {{ $examination->description }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/examinations">Examinations</a></li>
        <li class="active">{{ $examination->description }}</li>
    </ol>
    <br></br><hr/>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/examinations/{{ $examination->id }}/parts">Create/edit examination parts</a></li>
            <li class="divider">
            <li><a href="/examinations/{{ $examination->id }}/edit">Edit examination details</a></li>
            <li class="divider">
            <li><a href="/examinations/{{ $examination->id }}/instances">Generate sample exam</a></li>
            <li class="divider">
            <li><a href="/examinations/{{ $examination->id }}/assignment">Assign to grade section subjects</a></li>    
            <li class="divider">
            <li><a class="bg-info" href="/categories">View all categories</a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
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
                        <th>Quarter</th><td>{{ $examination->quarter }}</td>
                    </tr>
                    <tr>
                        <th>Created at:</th><td>{{ $examination->created_at }}</td>
                    </tr>
                </table>
            </div>
            @if($attachments->isEmpty())
            <div class="well">
                Not attached to any grade section subject yet.
            </div>
            @else
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Attched to the following grade section subjects
                </div>
                <table class="table table-striped">
                    <tr>
                        <td></td>
                        <th>Subject name</th>
                        <th>Section name</th>
                        <th>Publish on</th>
                    </tr>
                    <?php $count = 1 ?>
                    @foreach ($attachments as $attachment)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $attachment->gradeSectionSubject->subject->name }}</td>
                        <td>{{ $attachment->gradeSectionSubject->gradeSection->getName->name }}</td>
                        <td>{{ $attachment->getUnformattedDate('publish_on') }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@stop