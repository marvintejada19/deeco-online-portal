@extends('layouts.app')

@section('title')
    Subjects and Sections
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/subject-sections/">Subjects and Sections</a></li>
        <li class="active">Sections</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sections
                </div>
                @if (empty($sections))
                <div class="panel-body">
                    No sections found.
                </div>
                @else
                <table class="table table-responsive table-bordered table-striped">
                    <tr>
                        <td></td>
                        <th>Grade level</th>
                        <th>Section name</th>
                    </tr>   
                    <?php $count = 1 ?> 
                    @foreach ($sections as $section)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $section->grade_level }}</td>
                        <td>{{ $section->section_name }}</td>
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