<?php $subjectPost = $article ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <button id='span_right_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 1)" style="display:;">
            <span class="glyphicon glyphicon-menu-right"></span>
        </button>
        <button id='span_down_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 0)" style="display: none;">
            <span class="glyphicon glyphicon-menu-down"></span>
        </button>
        <span class="glyphicon glyphicon-file"></span> 
        {{ $subjectPost->post->title }}
    </div>
    <div id="{{ $i }}" style="display:none;">
        <table class="table table-responsive">
            <tr>
                <td colspan="2">{!! $subjectPost->post->body !!}</td>
            </tr>
            <tr>
                <th>Published on:</th><td>{{ $subjectPost->getUnformattedDate('publish_on') }}</td>
            </tr>
        </table>
        <div class="well">
            @if (count($subjectPost->post->files) == 0)
                No files attached
            @else
            Files attached:
                <ul>
                    @foreach ($subjectPost->post->files as $file)
                        @include('layouts.file')
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>