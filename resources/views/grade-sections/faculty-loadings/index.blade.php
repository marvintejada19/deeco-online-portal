@extends('layouts.app')

@section('title')
    Faculty list
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Faculty list</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Faculty list
                </div>
                @if ($facultyList->isEmpty())
                <div class="panel-body">
                    No faculty found.
                </div>
                @else
                <table class="table table-responsive table-bordered table-striped">
                    <tr>
                        <td></td>
                        <th>Faculty name</th>
                        <th>ID number</th>
                    </tr>   
                    <?php $count = 1 ?> 
                    @foreach ($facultyList as $faculty)
                    <tr>
                        <td>{{ $count }}</td>
                        <td><a href="faculty-loadings/{{ $faculty->id }}">{{ $faculty->getInfo()->lastname }}, {{ $faculty->getInfo()->firstname }}</a></td>
                        <td>{{ $faculty->getInfo()->idNumber }}</td>
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