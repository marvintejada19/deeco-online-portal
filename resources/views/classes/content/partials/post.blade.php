<?php $post = $article ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <button id='span_right_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 1)" style="display:;">
            <span class="glyphicon glyphicon-menu-right"></span>
        </button>
        <button id='span_down_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 0)" style="display: none;">
            <span class="glyphicon glyphicon-menu-down"></span>
        </button>
        <span class="glyphicon glyphicon-file"></span> {{ $post->title }}
        <br></br>
    </div>
    <div id="{{ $i }}" style="display:none;">
        <table class="table table-responsive">
            <tr>
                <td colspan="2">{!! $post->body !!}</td>
            </tr>
            <tr class="bg-primary">
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