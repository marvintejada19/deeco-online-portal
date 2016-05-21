@extends('layouts.app')

@section('title')
    Students
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/users">Users</a></li>
        <li class="active">Students</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Students
                </div>
                @if ($users->isEmpty())
                <div class="panel-body">
                    No user found.
                </div>
                @else
                <table class="table table-responsive table-bordered table-striped">
                    <tr>
                        <td></td>
                        <th>Username</th>
                        <th>Last time logged in</th>
                    </tr>   
                    <?php $count = 1 ?> 
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->last_login }}</td>
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