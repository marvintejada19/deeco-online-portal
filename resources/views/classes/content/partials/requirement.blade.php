<?php $requirement = $article ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <button id='span_right_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 1)" style="display:;">
            <span class="glyphicon glyphicon-menu-right"></span>
        </button>
        <button id='span_down_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 0)" style="display: none;">
            <span class="glyphicon glyphicon-menu-down"></span>
        </button>
        <span class="glyphicon glyphicon-paperclip"></span> {{ $requirement->title }}
        <button type="button" class="btn btn-success pull-right" onclick="location.href='/classes/{{ $subject->id }}/requirements/{{ $requirement->id }}/submission'">
            Check submission status
        </button>
        <br></br>
    </div>
    <div id="{{ $i }}" style="display:none;">
        <table class="table table-responsive">
            <tr>
                <td colspan="4">{!! $requirement->body !!}</td>
            </tr>
            <tr>
                <th>Available from:</th><td>{{ $requirement->getUnformattedDate('event_start') }}</td>
                <th>Available until:</th><td>{{ $requirement->getUnformattedDate('event_end') }}</td>
            </tr>
            <tr class="bg-primary">
                <th colspan="2">Published at:</th><td colspan="2">{{ $requirement->getUnformattedDate('published_at') }}</td>
            </tr>
        </table>
        <div class="well">
            @if (count($requirement->files) == 0)
                No files attached
            @else
            Files attached:
                <ul>
                    @foreach ($requirement->files as $file)
                        @include('layouts.file')
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>