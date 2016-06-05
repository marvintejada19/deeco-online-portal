@extends('layouts.app')

@section('title')
    {{ $gradeSectionSubject->subject->name }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">{{ $gradeSectionSubject->subject->name }}</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h2>{{ $gradeSectionSubject->subject->name }}</h2>
            @if (empty($articles))
                <div class="well">
                    Nothing posted yet.
                </div>
            @else
                <?php $i = 0 ?>
                @foreach ($articles as $article)
                    @if (!strcmp($types[$i], 'P'))
                        @include('classes.content.partials.post')
                    @elseif (!strcmp($types[$i], 'R'))
                        @include('classes.content.partials.requirement')
                    @elseif (!strcmp($types[$i], 'E'))
                        @include('classes.content.partials.examination')
                    @elseif (!strcmp($types[$i], 'A'))
                        @include('subjects.content.partials.admin-article')
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