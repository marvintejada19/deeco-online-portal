@extends('layouts.app')

@section('title')
    Parts of {{ $examination->description }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/examinations">Examinations</a></li>
        <li><a href="/examinations/{{ $examination->id }}">{{ $examination->description }}</a></li>
        <li class="active">Parts</li>
    </ol>
    <br></br><hr/>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/examinations/{{ $examination->id }}/parts/create">Add a new examination part</a></li>
        </ul>
    </div>
    <font size='6'>Parts of {{ $examination->description }}</font><br></br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if ($examination->parts->isEmpty())
                <div class="col-md-8 col-md-offset-2 well">
                    No parts added yet. Click <a href="/examinations/{{ $examination->id }}/parts/create">here</a> to start adding examination parts. 
                </div>
            @else
                <?php $count = 1 ?>
                @foreach ($examination->parts as $part)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="/examinations/{{ $examination->id }}/parts/{{ $part->id }}">Part {{ $count }}</a>
                        <div class="dropdown pull-right">
                            <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li><a href="/examinations/{{ $examination->id }}/parts/{{ $part->id }}/edit">Edit examination part details</a></li>
                                <li class="divider"></li>
                                <li><a href="/examinations/{{ $examination->id }}/parts/{{ $part->id }}/delete">Delete examination part</a></li>
                            </ul>
                        </div>
                    </div>
                    <table class="table">
                        <tr>
                            <th style="width:50%">Question type:</th>
                            <td style="width:50%">{{ $part->getQuestionType() }}</td>
                        </tr>
                        <tr>
                            <th>Points per item:</th>
                            <td>{{ $part->points }}</td>
                        </tr>
                        <tr>
                            <th>Current no. of questions:</th>
                            <td>{{ $part->getQuestionsCount() }}</td>
                        </tr>
                        <tr>
                            <th>Total no. of questions:</th>
                            <td>{{ $part->questions_quantity }}</td>
                        </tr>
                    </table>
                </div>
                <?php $count++ ?>
                @endforeach
            @endif
        </div>
    </div>
</div>
@stop