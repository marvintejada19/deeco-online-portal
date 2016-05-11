<?php $examination = $article ?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <button id='span_right_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 1)" style="display:;">
            <span class="glyphicon glyphicon-menu-right"></span>
        </button>
        <button id='span_down_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 0)" style="display: none;">
            <span class="glyphicon glyphicon-menu-down"></span>
        </button>
        <span class="glyphicon glyphicon-list-alt"></span> {{ $examination->title }}
        <button type="button" class="btn btn-warning pull-right" onclick=''>
            Check examination status
        </button>
        <br></br>
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