@extends('layouts.app')

@section('title')
    {{ $subject->subject_title }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li class="active">{{ $subject->subject_title }}</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h2>{{ $subject->subject_title }}</h2>
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-info" onclick="location.href='/subjects/{{ $subject->id }}/posts'">
                        <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Posts
                    </button>
                    <button type="button" class="btn btn-success" onclick="location.href='/subjects/{{ $subject->id }}/requirements'">
                        <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> Requirements
                    </button>
                    <button type="button" class="btn btn-warning" onclick="location.href='/subjects/{{ $subject->id }}/examinations'">
                        <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Examinations
                    </button>
                    <button type="button" class="btn btn-primary pull-right" onclick="location.href='/subjects/{{ $subject->id }}/details'">
                        View details
                    </button>
                </div>
            </div>
            @if (empty($articles))
                <div class="well">
                    Nothing posted yet.
                </div>
            @else
                <?php $i = 0 ?>
                @foreach ($articles as $article)
                    @if (!strcmp($types[$i], 'P'))
                        @include('subjects.content.partials.post')
                    @elseif (!strcmp($types[$i], 'R'))
                        @include('subjects.content.partials.requirement')
                    @elseif (!strcmp($types[$i], 'E'))
                        @include('subjects.content.partials.examination')
                    @endif
                    <?php $i++ ?>
                @endforeach
            @endif
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