<?php $subjectRequirement = $article ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <button id='span_right_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 1)" style="display:;">
            <span class="glyphicon glyphicon-menu-right"></span>
        </button>
        <button id='span_down_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 0)" style="display: none;">
            <span class="glyphicon glyphicon-menu-down"></span>
        </button>
        <span class="glyphicon glyphicon-paperclip"></span> 
        {{ $subjectRequirement->requirement->title }}
        <button type="button" class="btn btn-success pull-right" onclick="location.href='/subjects/{{ $gradeSectionSubject->id }}/requirements/{{ $subjectRequirement->id }}/submissions'">
            Check submission status of students
        </button>
        <br></br>
    </div>
    <div id="{{ $i }}" style="display:none;">
        <table class="table table-responsive">
            <tr>
                <td colspan="4">{!! $subjectRequirement->requirement->body !!}</td>
            </tr>
            <tr>
                <th>Students can upload from:</th><td>{{ $subjectRequirement->getUnformattedDate('event_start') }}</td>
                <th>Students can upload until:</th><td>{{ $subjectRequirement->getUnformattedDate('event_end') }}</td>
            </tr>
            <tr>
                <th>Published on:</th><td>{{ $subjectRequirement->getUnformattedDate('publish_on') }}</td>
                <td colspan="2"></td>
            </tr>
        </table>
        <div class="well">
            @if (count($subjectRequirement->requirement->files) == 0)
                No files attached
            @else
            Files attached:
                <ul>
                    @foreach ($subjectRequirement->requirement->files as $file)
                        @include('layouts.file')
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>