<?php $deployment = $article ?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <button id='span_right_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 1)" style="display:;">
            <span class="glyphicon glyphicon-menu-right"></span>
        </button>
        <button id='span_down_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 0)" style="display: none;">
            <span class="glyphicon glyphicon-menu-down"></span>
        </button>
        <span class="glyphicon glyphicon-list-alt"></span> 
        {{ $deployment->examination->description }}
        <button type="button" class="btn btn-warning pull-right" onclick="location.href='/subjects/{{ $gradeSectionSubject->id }}/student-results/{{ $deployment->id }}'">
            Check examination status of students
        </button>
        <br></br>
    </div>
    <div id="{{ $i }}" style="display:none;">
        <table class="table table-responsive">
            <tr>
                <th colspan="2">Subcategory:</th><td colspan="2">{{ $deployment->examination->subcategory }}</td>
            </tr>
            <tr>
                <th colspan="2">Total points:</th><td colspan="2">{{ $deployment->examination->computeTotalPoints() }}</td>
            </tr>
            <tr>
                <th>Exam start:</th><td>{{ $deployment->getUnformattedDate('exam_start') }}</td>
                <th>Exam end:</th><td>{{ $deployment->getUnformattedDate('exam_end') }}</td>
            </tr>
            <tr>
                <th>Published on:</th><td>{{ $deployment->getUnformattedDate('publish_on') }}</td>
                <td colspan="2"></td>
            </tr>
        </table>
    </div>
</div>