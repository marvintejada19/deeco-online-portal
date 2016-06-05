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
    <font size='6'>Included question</font><br/>
    <font size='3'>Type of questions: <b>{{ $part->getQuestionType() }}</b></font><br></br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if ($part->items->isEmpty())
                <div class="col-md-8 col-md-offset-2 well">
                    No specific question included yet. Click <a href="/examinations/{{ $examination->id }}/parts/{{ $part->id }}/items/create">here</a> to specify the question. 
                </div>
            @else
                <div class="col-md-8 col-md-offset-2 well">
                    Click <a href="/examinations/{{ $examination->id }}/parts/{{ $part->id }}/items/create">here</a> to change the specified question. The previous one will be removed.
                </div>
                @foreach ($part->items as $item)
                <table class="table table-bordered">
                    <tr>
                        <th style="width:25%">Question:</th>
                        <th style="width:75%" colspan="3">{{ $question->title }}</th>
                    </tr>
                    <tr>
                        <th>Category:</th>
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