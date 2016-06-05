@extends('layouts.app')

@section('title')
    Faculty loadings
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/faculty-loadings">Faculty list</a></li>
        <li class="active">Faculty loadings</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Faculty loadings of {{ $user->getInfo()->lastname }}, {{ $user->getInfo()->firstname }}
                </div>
                @if ($facultyLoadings->isEmpty())
                <div class="panel-body">
                    No faculty loadings found.
                </div>
                @else
                <table class="table table-responsive table-bordered table-striped">
                    <tr>
                        <td></td>
                        <th>Subject name</th>
                        <th>Section</th>
                    </tr>   
                    <?php $count = 1 ?> 
                    @foreach ($facultyLoadings as $facultyLoading)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $facultyLoading->gradeSectionSubject->subject->name }}</td>
                        <td>{{ $facultyLoading->gradeSectionSubject->gradeSection->getName->name }}</td>
                    </tr>
                    <?php $count++ ?>
                    @endforeach
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@stop