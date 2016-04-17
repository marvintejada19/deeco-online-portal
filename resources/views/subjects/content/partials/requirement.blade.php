<?php $requirement = $article ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-paperclip"></span> {{ $requirement->title }}
        <div class="dropdown pull-right">
            <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dLabel">
                <li><a href="/subjects/{{ $subject->id }}/requirements/{{ $requirement->id }}/edit">Edit requirement</a></li>
                <li class="divider"></li>
                <li><a href="/subjects/{{ $subject->id }}/requirements/{{ $requirement->id }}/delete">Delete requirement</a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        {!! $requirement->body !!}
        @if (count($requirement->files) != 0)
            <hr/>
            <ul>
                @foreach ($requirement->files as $file)
                    @include('layouts.file')
                @endforeach
            </ul>
        @endif
    </div>
</div>