<?php $post = $article ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-file"></span> {{ $post->title }}
        <div class="dropdown pull-right">
            <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dLabel">
                <li><a href="/subjects/{{ $subject->id }}/posts/{{ $post->id }}/edit">Edit post</a></li>
                <li class="divider"></li>
                <li><a href="/subjects/{{ $subject->id }}/posts/{{ $post->id }}/delete">Delete post</a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        {!! $post->body !!}
        @if (count($post->files) != 0)
            <hr/>
            <ul>
                @foreach ($post->files as $file)
                    @include('layouts.file')
                @endforeach
            </ul>
        @endif
    </div>
</div>