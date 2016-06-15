@extends('layouts.app')

@section('title')
    {{ $gradeSectionSubject->subject->name }} ({{ $gradeSectionSubject->gradeSection->getName->name }})
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">{{ $gradeSectionSubject->subject->name }} ({{ $gradeSectionSubject->gradeSection->getName->name }})</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <font size='6'>{{ $gradeSectionSubject->subject->name }} ({{ $gradeSectionSubject->gradeSection->getName->name }})</font>
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="/subjects/{{ $gradeSectionSubject->id }}/class-record">View class record</a></li>
                    <li class="divider">
                    <li><a href="/subjects/{{ $gradeSectionSubject->id }}/details">View details</a></li>
                </ul>
            </div>
            <br></br>
            @if (empty($articles))
                <div class="well">
                    Nothing posted yet.
                </div>
            @else
                <?php $i = 0 ?>
                @foreach ($articles as $article)
                    @if (!strcmp($types[$i], 'P'))
                        @include('grade-section-subjects.content.partials.post')
                    @elseif (!strcmp($types[$i], 'R'))
                        @include('grade-section-subjects.content.partials.requirement')
                    @elseif (!strcmp($types[$i], 'E'))
                        @include('grade-section-subjects.content.partials.examination')
                    @elseif (!strcmp($types[$i], 'A'))
                        @include('grade-section-subjects.content.partials.admin-article')
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