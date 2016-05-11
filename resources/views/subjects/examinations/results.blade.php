@extends('layouts.app')

@section('title')
    Examination results
@endsection

@section('content')
<div class="container">
     <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title}}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations">All examinations</a></li>
        <li class="active">Results {{ $examination->title }}</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary well">
                <div class="panel-heading">
                    <h5>Results of {{ $examination->title }}</h5>
                </div>
                <table class="table table-responsive table-hover">
                    <tr>
                        <th>Title:</th><td>{{ $examination->title }}</td>
                    </tr>
                    <tr>
                        <th>Score:</th>
                        <td>{{ $instance->score }} / {{ $examination->total_points }}</td>
                    </tr>
                    <tr>
                        <th>Time started:</th>
                        <td>{{ $timeStarted }}</td>
                    </tr>
                    <tr>
                        <th>Time ended:</th>
                        <td>{{ $timeEnded }}</td>
                    </tr>
                </table>
            </div>
            <hr/>   
            <?php $count = 0 ?>
            @foreach ($examination->questions as $question)
                @if (!strcmp($question->getQuestionType(), 'Matching Type'))
                <div class="panel panel-info">    
                @elseif (!strcmp($answers[$question->id], $correctAnswers[$question->id]))
                <div class="panel panel-success">
                @else
                <div class="panel panel-danger">
                @endif
                    <div class="panel-heading">
                        <button id='span_right_{{ $count }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $count }}', 1)" style="display:;">
                            <span class="glyphicon glyphicon-menu-right"></span>
                        </button>
                        <button id='span_down_{{ $count }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $count }}', 0)" style="display: none;">
                            <span class="glyphicon glyphicon-menu-down"></span>
                        </button>
                        {{ $question->title }}
                        @if (!strcmp($question->getQuestionType(), 'Multiple Choice'))
                            <span class="glyphicon glyphicon-option-horizontal pull-right"></span>
                        @elseif (!strcmp($question->getQuestionType(), 'True or False'))
                            <span class="glyphicon glyphicon-adjust pull-right"></span>
                        @elseif (!strcmp($question->getQuestionType(), 'Fill in the Blanks'))
                            <span class="glyphicon glyphicon-question-sign pull-right"></span>
                        @elseif (!strcmp($question->getQuestionType(), 'Matching Type'))
                            <span class="glyphicon glyphicon-th-list pull-right"></span>
                        @endif
                    </div>
                    <div id='{{ $count }}' style="display:none;">
                    <table class="table table-responsive table-bordered table-striped">
                        <tr>
                            <th>Points per item:</th><td>{{ $question->points }}</td>
                        </tr>
                        <tr>
                            <td class="bg-primary" colspan="2">{!! $question->body !!}</td>
                        </tr>
                        @unless (!strcmp($question->getQuestionType(), 'Matching Type'))
                        <tr>
                            <th>Your answer:</th>
                            <td>{{ $answers[$question->id] }}</td>
                        </tr>
                        <tr>
                            <th>Correct answer:</th>
                            <td>{{ $correctAnswers[$question->id] }}</td>
                        </tr>
                        @endunless
                        @if (!strcmp($question->getQuestionType(), 'Matching Type'))
                        <tr>
                            <table class="table table-bordered table-responsive">
                                <tr>
                                    <th></th>
                                    <th>Your answer:</th>
                                    <th>Correct answer:</th>
                                </tr>
                                @foreach ($matchingTypeItems[$question->matchingType->id] as $item)
                                    <tr>
                                        <th>{{ $item->text }}</th>
                                        <td class="{{ (!strcmp($matchingTypeAnswers[$item->id], $item->correct_answer)) ? 'bg-success' : 'bg-danger' }}">{{ $matchingTypeAnswers[$item->id] }}</td>
                                        <td class="bg-info">{{ $item->correct_answer }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </tr>
                        @endif
                    </table>
                    </div>
                </div>
            <?php $count++ ?> 
            @endforeach
        </div>
    </div>
</div>
<script type="text/javascript">
    function showhide(id, counter) {
        var e = document.getElementById(id);
        e.style.display = (e.style.display == 'block') ? 'none' : 'block';

        if(counter){
            var spanId = 'span_right_' + id;
            document.getElementById(spanId).style.display = 'none';
            var spanId2 = 'span_down_' + id; 
            document.getElementById(spanId2).style.display = '';
        } else {
            var spanId = 'span_down_' + id; 
            document.getElementById(spanId).style.display = 'none';
            var spanId2 = 'span_right_' + id; 
            document.getElementById(spanId2).style.display = '';
        }
   }
</script>
@endsection