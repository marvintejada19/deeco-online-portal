@extends('layouts.app')

@section('title')
    {{ $examination->title }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title}}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations">All examinations</a></li>
        <li class="active">{{ $examination->title }}</li>
    </ol>
    <br></br><hr/>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/questions">
                <span class="glyphicon glyphicon-wrench"></span> Add/remove questions
            </a></li>
            <li class="divider">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/edit">Edit examination</a></li>
            <li class="divider">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/questions/list">View all added questions</a></li>
            <li class="divider">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/instances">Generate sample exam</a></li>
            <li class="divider">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/delete">Delete examination</a></li>
            <li class="divider">
            <li><a class="bg-info" href="/categories/subjects/{{ $subject->id }}">View all categories</a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    @if (!$examination->is_published)
                    {!! Form::open(['url' => '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/publish']) !!}
                        Status: {!! $status !!}
                        <button type="submit" class="btn btn-success pull-right">
                            Publish examination
                        </button>
                        <br></br>
                    {!! Form::close() !!}
                    @else
                        Status: {!! $status !!}
                        <button id='span_right_0' type="button" class="btn btn-default btn-xs pull-right" onclick="showhide('0', 1)" style="display:;">
                            <span class="glyphicon glyphicon-menu-up"></span>
                        </button>
                        <button id='span_down_0' type="button" class="btn btn-default btn-xs pull-right" onclick="showhide('0', 0)" style="display: none;">
                            <span class="glyphicon glyphicon-menu-down"></span>
                        </button>
                        <br></br>
                    </div>
                    <div class="panel-body" id="0" style="display:none;">
                        {!! Form::open(['url' => '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/unpublish']) !!}
                            <h5><font color='red'>* Unpublishing will delete all instances of current examination.</font></h5>
                            <button type="submit" class="btn btn-danger pull-right">
                                Unpublish examination
                            </button>
                        {!! Form::close() !!}
                    @endif
                </div>   
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Examination details
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Title:</th><td>{{ $examination->title }}</td>
                    </tr>
                    <tr>
                        <th>Number of questions:</th><td>{{ count($examination->questions) }}</td>
                    </tr>
                    <tr>
                        <th>Total points:</th><td>{{ $examination->total_points }}</td>
                    </tr>
                    <tr>
                        <th>Available from:</th><td>{{ $examination->getUnformattedDate('exam_start') }}</td>
                    </tr>
                    <tr>
                        <th>Available until:</th><td>{{ $examination->getUnformattedDate('exam_end') }}</td>
                    </tr>
                    <tr>
                        <th>Created at:</th><td>{{ $examination->created_at }}</td>
                    </tr>
                </table>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Scores of students
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th></th>
                        <th>Student username</th>
                        <th>Score</th>
                        <th>Time started</th>
                        <th>Time ended</th>
                    </tr>
                    <?php $count = 1 ?>
                    @foreach ($subject->students as $student)
                    <tr>
                        <th>{{ $count }}</th>
                        <th>{{ $student->username }}</th>
                        <th>{{ ($exams[$student->id] == null) ? 'None' : $exams[$student->id]->score }}</th>
                        <th>{{ ($exams[$student->id] == null) ? 'None' : $exams[$student->id]->time_started }}</th>
                        <th>{{ ($exams[$student->id] == null) ? 'None' : $exams[$student->id]->time_ended }}</th>
                    </tr>
                    <?php $count++ ?>
                    @endforeach
                </table>
            </div>
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
@stop