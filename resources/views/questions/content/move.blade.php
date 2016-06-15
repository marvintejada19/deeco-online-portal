@extends('layouts.app')

@section('title')
    Move question
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}">Back to page</a></li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Move question
                </div>
                <div class="panel-body">
                    @include('questions.content.search')

                    @if ($selectedTopic)
                    {!! Form::open(['url' => '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id . '/move/do']) !!}
                        <div class="form-group">
                            {!! Form::label('question_subtopic_id', 'Subtopic', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                <select name="question_subtopic_id" id="subtopic_ddl" onchange="configureSubtopicDropDownLists()" class="form-control" required>
                                    <option value="" disabled selected>Select from the following...</option>
                                    @foreach ($subtopics as $key => $name)
                                        <option value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group pull-right">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" class="btn btn-danger" onclick="location.href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}'">
                                    Back
                                </button>
                            </div>
                        </div>

                        <div class="form-group pull-right">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Move question', ['class' => 'btn btn-primary form-control']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function configureTopicDropDownLists() {
        ddl1 = document.getElementById('category_ddl');
        ddl2 = document.getElementById('topic_ddl');

        switch (ddl1.value) {
            <?php 
            foreach ($categories as $category){
                echo "case '" . $category->id . "': " .
                        "ddl2.options.length = 0; ".
                        "var opt0 = document.createElement('option'); ";
                foreach ($topics[$category->id] as $topic){
                echo    "var opt = document.createElement('option'); " .
                        "opt.value = '" . $topic->id . "'; " .
                        "opt.text = '" . $topic->name . "'; " .
                        "ddl2.options.add(opt);";
                }
                echo    "break;";
            }
            ?>
            default:
                ddl2.options.length = 0;
        }
    }
</script>
@stop