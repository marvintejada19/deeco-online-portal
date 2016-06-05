@extends('layouts.app')

@section('title')
    Included questions
@endsection

@section('content')
<div class="container">
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/examinations">Examinations</a></li>
        <li><a href="/examinations/{{ $examination->id }}">{{ $examination->description }}</a></title>
        <li><a href="/examinations/{{ $examination->id }}/parts">Parts</a></li>
        <li class="active">Included questions</li>
    </ol>
    <br></br><hr/>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/examinations/{{ $examination->id }}/parts/{{ $part->id }}/items/create">Add a new examination part item</a></li>
        </ul>
    </div>
    <font size='6'>Included questions</font><br/>
    <font size='3'>Type of questions: <b>{{ $part->getQuestionType() }}</b></font><br></br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if ($part->items->isEmpty())
                <div class="col-md-8 col-md-offset-2 well">
                    No questions included yet. Click <a href="/examinations/{{ $examination->id }}/parts/{{ $part->id }}/items/create">here</a> to start including questions. 
                </div>
            @else
                @foreach ($part->items as $item)
                <table class="table table-bordered">
                    <tr>
                        <th style="width:25%">Category:</th>
                        <td style="width:45%">{{ $item->questionSubtopic->questionTopic->questionCategory->name }}</td>
                        <td style="width:30%" colspan="2" rowspan="2">
                        <div class="dropdown pull-right">
                            <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li><a href="/examinations/{{ $examination->id }}/parts/{{ $part->id }}/items/{{ $item->id }}/delete">Delete examination part item</a></li>
                            </ul>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Topic:</th>
                        <td>{{ $item->questionSubtopic->questionTopic->name }}</td>
                    </tr>
                    <tr>
                        <th>Subtopic:</th>
                        <td>{{ $item->questionSubtopic->name }}</td>
                        <th style="width:15%">Quantity:</th>
                        <td style="width:15%">{{ $item->quantity }}</td>
                    </tr>
                </table>
                @endforeach
            @endif
        </div>
    </div>
</div>
@stop