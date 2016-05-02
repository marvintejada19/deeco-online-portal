@extends('layouts.app')

@section('title')
    {{ $category->name }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/categories">All categories</a></li>
        <li class="active">{{ $category->name }}</li>
    </ol>
    <br></br><hr/>
    <font size='4'><b>Category: &nbsp;</b></font><font size='6'>{{ $category->name }}</font>
    <button type="button" class="btn btn-primary pull-right" onclick="location.href='/categories/{{ $category->name }}/topics/create'">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a new topic
    </button>
    <br></br>
    <?php $count = 0 ?>
    @foreach ($topics as $topic)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button id='span_right_{{ $count }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $count }}', 1)" style="display:;">
                        <span class="glyphicon glyphicon-menu-right"></span>
                    </button>
                    <button id='span_down_{{ $count }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $count }}', 0)" style="display: none;">
                        <span class="glyphicon glyphicon-menu-down"></span>
                    </button>
                    <a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}">{{ $topic->name }}</a>
                    @if (strcmp($topic->name, 'Default Topic') != 0)
                    <div class="dropdown pull-right">
                        <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/edit">Edit name</a></li>
                            <li class="divider"></li>
                            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/delete">Delete topic</a></li>
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="panel-body" id='{{ $count }}' style="display:none;">
                    <button type="button" class="btn btn-primary btn-xs" onclick="location.href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/create'">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a new subtopic
                    </button>
                    <br></br>
                    @foreach ($topic->questionSubtopics as $subtopic)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}'>{{ $subtopic->name }}</a>
                                @if (strcmp($subtopic->name, 'Default Subtopic') != 0)
                                <div class="dropdown pull-right">
                                    <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                                        <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/edit">Edit name</a></li>
                                        <li class="divider"></li>
                                        <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/delete">Delete subtopic</a></li>
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </div>
        </div>
    <?php $count++ ?>
    @endforeach
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