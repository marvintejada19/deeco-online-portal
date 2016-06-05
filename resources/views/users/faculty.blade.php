@extends('layouts.app')

@section('title')
    Faculty
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Faculty</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Faculty
                </div>
                @if ($users->isEmpty())
                <div class="panel-body">
                    No user found.
                </div>
                @else
                <table class="table table-responsive table-bordered table-hover">
                    <tr>
                        <td style="width:5%"></td>
                        <th>Username</th>
                        <th>Lastname</th>
                        <th>Firstname</th>
                        <th style="width:10%">ID number</th>
                        <th style="width:15%">Last time logged in</th>
                        <td style="width:5%"></td>
                    </tr>   
                    <?php $count = 1 ?> 
                    @foreach ($users as $user)
                    <tr <?php echo (($user->active) ? '' : ' class="bg-danger"') ?>>
                        <td>{{ $count }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->getInfo()->lastname }}</td>
                        <td>{{ $user->getInfo()->firstname }}</td>
                        <td>{{ $user->getInfo()->idNumber }}</td>
                        <td>{{ $user->last_login }}</td>
                        <td>
                            <div class="dropdown pull-right">
                                <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dLabel">
                                    @if ($user->active)
                                    <li><a href="/users/{{ $user->id }}/edit">Edit user details</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/users/deactivate/{{ $user->id }}">Deactivate account</a></li>
                                    @else
                                    <li><a href="/users/activate/{{ $user->id }}">Activate account</a></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
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