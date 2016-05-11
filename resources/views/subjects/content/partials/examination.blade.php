<?php $examination = $article ?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <button id='span_right_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 1)" style="display:;">
            <span class="glyphicon glyphicon-menu-right"></span>
        </button>
        <button id='span_down_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 0)" style="display: none;">
            <span class="glyphicon glyphicon-menu-down"></span>
        </button>
        <span class="glyphicon glyphicon-list-alt"></span> 
        <a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}">
            {{ $examination->title }}
        </a>
        <div class="dropdown pull-right">
            <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dLabel">
                <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/edit">Edit examination</a></li>
                <li class="divider"></li>
                <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/delete">Delete examination</a></li>
            </ul>
        </div>
    </div>
    <div id="{{ $i }}" style="display:none;">
        <table class="table table-responsive">
            <tr>
                <th>Number of questions:</th><td>{{ count($examination->questions) }}</td>
            </tr>
            <tr>
                <th>Total points:</th><td>{{ $examination->total_points }}</td>
            </tr>
            <tr class="bg-primary">
                <th>Published at:</th><td>{{ $examination->getUnformattedDate('published_at') }}</td>
            </tr>
        </table>
    </div>
</div>