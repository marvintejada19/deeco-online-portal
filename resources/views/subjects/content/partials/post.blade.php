<?php $post = $article ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <button id='span_right_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 1)" style="display:;">
            <span class="glyphicon glyphicon-menu-right"></span>
        </button>
        <button id='span_down_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 0)" style="display: none;">
            <span class="glyphicon glyphicon-menu-down"></span>
        </button>
        <span class="glyphicon glyphicon-file"></span> 
        <a href="/subjects/{{ $subject->id }}/posts/{{ $post->id }}">
            {{ $post->title }}
        </a>
        <div class="dropdown pull-right">
            <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dLabel">
                <li><a href="/subjects/{{ $subject->id }}/posts/{{ $post->id }}/edit">Edit post details</a></li>
            </ul>
        </div>
    </div>
    <div id="{{ $i }}" style="display:none;">
        <table class="table table-responsive">
            <tr>
                <td colspan="2">{!! $post->body !!}</td>
            </tr>
            <tr>
                <th>Published at:</th><td>{{ $post->getUnformattedDate('published_at') }}</td>
            </tr>
        </table>
        <div class="well">
            @if (count($post->files) == 0)
                No files attached
            @else
            Files attached:
                <ul>
                    @foreach ($post->files as $file)
                        @include('layouts.file')
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>