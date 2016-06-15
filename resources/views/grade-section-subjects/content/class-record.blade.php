@extends('layouts.app')

@section('title')
	View class record
@endsection

@section('content')
<div class="container">
	<ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $gradeSectionSubject->id }}">{{ $gradeSectionSubject->subject->name }} ({{ $gradeSectionSubject->gradeSection->getName->name }})</a></li>
        <li class="active">Class record</a></li>
    </ol>
    <br></br><hr/>

@for ($i = 1; $i <= count($classRecordsInQuarter); $i++)
	<?php $classRecords = $classRecordsInQuarter[$i] ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<button id='span_right_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 1)" style="display:;">
	            <span class="glyphicon glyphicon-menu-right"></span>
	        </button>
	        <button id='span_down_{{ $i }}' type="button" class="btn btn-default btn-xs" onclick="showhide('{{ $i }}', 0)" style="display: none;">
	            <span class="glyphicon glyphicon-menu-down"></span>
	        </button>
	        Quarter {{ $i }}
		</div>
		<div id="{{ $i }}" style="display:none;" style="overflow:auto;">
		<table class="table table-hover table-bordered">
			<tr>
				<th style="width:20%"></th>
				<th colspan="{{ count($classRecords['Seatwork']) }}">Seatworks</th>
				<th colspan="{{ count($classRecords['Homework']) }}">Homeworks</th>
				<th colspan="{{ count($classRecords['Quiz']) }}">Quizzes</th>
				<th colspan="{{ count($classRecords['Long test']) }}">Long tests</th>
				<th colspan="{{ count($classRecords['Others']) }}">Others</th>
			</tr>
			<tr>
				<td style="width:20%"></td>
				@foreach ($classRecords as $key => $record)
					<?php $count = 1 ?>
					@if (count($classRecords[$key]) == 0)
						<td></td>
					@endif
					@foreach ($classRecords[$key] as $record)
						<td>
					        <?php
					        	$title = 	"Description: " . $record->deployment->examination->description .
					        				"<br/>" .
					        				"Date deployed: " . $record->deployment->getUnformattedDate('publish_on') .
					        				"<br/>" .
					        				"Total points: " . $record->deployment->examination->computeTotalPoints();

					        ?>
					        <!-- <button type="button" class="btn btn-default" data-html="true" data-toggle="tooltip" data-placement="top" title="{{ $title }}">
					        	A
					        </button> -->
					        <p data-html="true" data-toggle="tooltip" data-placement="top" title="{{ $title }}"><b>{{ $count++ }}</b></p>
						</td>
					@endforeach
				@endforeach
			</tr>

			@foreach ($maleStudents as $student)
			<tr>
				<td>{{ $student->getFullName() }}
				</td>
				
				@foreach ($classRecords as $key => $classRecord)
					@if (count($classRecords[$key]) == 0)
						<td></td>
					@endif
					@foreach ($classRecords[$key] as $classRecord)
					<td><?php $record = $classRecord->instances()->where('user_id', $student->id)->first();
						echo (($record == null) ? '' : $record->score);
					?></td>
					@endforeach
				@endforeach
			</tr>
			@endforeach
			
			<tr>
				<td colspan="{{ max(1, count($classRecords['Seatwork'])) + max(1, count($classRecords['Homework'])) + max(1, count($classRecords['Quiz'])) + max(1, count($classRecords['Long test'])) + max(1, count($classRecords['Others'])) + 1 }}" class="bg-danger"></td>
			</tr>

			@foreach ($femaleStudents as $student)
			<tr>
				<td>{{ $student->getFullName() }}
				</td>
				
				@foreach ($classRecords as $key => $classRecord)
					@if (count($classRecords[$key]) == 0)
						<td></td>
					@endif
					@foreach ($classRecords[$key] as $classRecord)
					<td><?php $record = $classRecord->instances()->where('user_id', $student->id)->first();
						echo (($record == null) ? '' : $record->score);
					?></td>
					@endforeach
				@endforeach
			</tr>
			@endforeach		
		</table>
		</div>
	</div>
@endfor

</div>
<script type="text/javascript">
    function showhide(id, counter) {
        var e = document.getElementById(id);
        e.style.display = (e.style.display == 'block') ? 'none' : 'block';

        if(counter){
            var spanId = 'span_right_' + id;
            document.getElementById(spanId).style.display = 'none';
            var spanId2 = 'span_down_' + id; 
            document.getElementById(spanId2).style.display = '';
        } else {
            var spanId = 'span_down_' + id; 
            document.getElementById(spanId).style.display = 'none';
            var spanId2 = 'span_right_' + id; 
            document.getElementById(spanId2).style.display = '';
        }
   }
</script>
@endsection