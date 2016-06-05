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
	<div class="row">
		<table class="table table-responsive table-hover table-bordered">
			<tr>
				<th style="width:20%"></th>
				<th colspan="{{ $seatworkCount }}">Seatworks</th>
				<th colspan="{{ $homeworkCount }}">Homeworks</th>
				<th colspan="{{ $quizCount }}">Quizzes</th>
				<th colspan="{{ $longTestCount }}">Long test</th>
				<th colspan="{{ $othersCount }}">Others</th>
			</tr>
			<tr>
				<td style="width:20%"></td>

				@if ($seatworkCount == 0)
					<td></td>
				@endif
				@foreach ($seatworkClassRecords as $seatworkClassRecord)
					<td>
						<div class="dropdown">
            				<button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                				<span class="caret"></span>
            				</button>
				            <ul class="dropdown-menu" aria-labelledby="dLabel">
				                <li>Description: {{ $homeworkClassRecord->examination->description }}</li>
				                <li class="divider"></li>
				                <li>Date deployed: {{ $homeworkClassRecord->examination->deployments()->where('grade_section_subject_id', $gradeSectionSubject->id)->first()->publish_on }}</li>
				                <li class="divider"></li>
				                <li>Total points: {{ $homeworkClassRecord->examination->total_points }}</li>
				            </ul>
				        </div>
					</td>
				@endforeach

				@if ($homeworkCount == 0)
					<td></td>
				@endif
				@foreach ($homeworkClassRecords as $homeworkClassRecord)
					<td>
						<div class="dropdown">
            				<button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                				<span class="caret"></span>
            				</button>
				            <ul class="dropdown-menu" aria-labelledby="dLabel">
				                <li>Description: {{ $homeworkClassRecord->examination->description }}</li>
				                <li class="divider"></li>
				                <li>Date deployed: {{ $homeworkClassRecord->examination->deployments()->where('grade_section_subject_id', $gradeSectionSubject->id)->first()->publish_on }}</li>
				                <li class="divider"></li>
				                <li>Total points: {{ $homeworkClassRecord->examination->total_points }}</li>
				            </ul>
				        </div>
					</td>
				@endforeach

				@if ($quizCount == 0)
					<td></td>
				@endif
				@foreach ($quizClassRecords as $quizClassRecord)
					<td>
						<div class="dropdown">
            				<button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                				<span class="caret"></span>
            				</button>
				            <ul class="dropdown-menu" aria-labelledby="dLabel">
				                <li>Description: {{ $quizClassRecord->examination->description }}</li>
				                <li class="divider"></li>
				                <li>Date deployed: {{ $quizClassRecord->examination->deployments()->where('grade_section_subject_id', $gradeSectionSubject->id)->first()->publish_on }}</li>
				                <li class="divider"></li>
				                <li>Total points: {{ $quizClassRecord->examination->total_points }}</li>
				            </ul>
				        </div>
					</td>
				@endforeach

				@if ($longTestCount == 0)
					<td></td>
				@endif
				@foreach ($longTestClassRecords as $longTestClassRecord)
					<td>
						<div class="dropdown">
            				<button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                				<span class="caret"></span>
            				</button>
				            <ul class="dropdown-menu" aria-labelledby="dLabel">
				                <li>Description: {{ $longTestClassRecord->examination->description }}</li>
				                <li class="divider"></li>
				                <li>Date deployed: {{ $longTestClassRecord->examination->deployments()->where('grade_section_subject_id', $gradeSectionSubject->id)->publish_on }}</li>
				                <li class="divider"></li>
				                <li>Total points: {{ $longTestClassRecord->examination->total_points }}</li>
				            </ul>
				        </div>
				   </td>
				@endforeach

				@if ($othersCount == 0)
					<td></td>
				@endif
				@foreach ($othersClassRecords as $othersClassRecord)
					<td>
						<div class="dropdown">
            				<button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                				<span class="caret"></span>
            				</button>
				            <ul class="dropdown-menu" aria-labelledby="dLabel">
				                <li>Description: {{ $othersClassRecord->examination->description }}</li>
				                <li class="divider"></li>
				                <li>Date deployed: {{ $othersClassRecord->examination->deployments()->where('grade_section_subject_id', $gradeSectionSubject->id)->publish_on }}</li>
				                <li class="divider"></li>
				                <li>Total points: {{ $othersClassRecord->examination->total_points }}</li>
				            </ul>
				        </div>
				   </td>
				@endforeach
			</tr>

			@foreach ($students as $student)
			<tr>
				<td>{{ $student->getInfo()->lastname }}, {{ $student->getInfo()->firstname }}
				</td>
				
				@if ($seatworkCount == 0)
					<td></td>
				@endif
				@foreach ($seatworkClassRecords as $seatworkClassRecord)
				<td><?php $record = $seatworkClassRecord->instances()->where('user_id', $student->id)->first();
					echo (($record == null) ? '' : $record->score);
				?></td>
				@endforeach

				@if ($homeworkCount == 0)
					<td></td>
				@endif
				@foreach ($homeworkClassRecords as $homeworkClassRecord)
				<td><?php $record = $homeworkClassRecord->instances()->where('user_id', $student->id)->first();
					echo (($record == null) ? '' : $record->score);
				?></td>
				@endforeach

				@if ($quizCount == 0)
					<td></td>
				@endif
				@foreach ($quizClassRecords as $quizClassRecord)
				<td><?php $record = $quizClassRecord->instances()->where('user_id', $student->id)->first();
					echo (($record == null) ? '' : $record->score);
				?></td>
				@endforeach
				
				@if ($longTestCount == 0)
					<td></td>
				@endif
				@foreach ($longTestClassRecords as $longTestClassRecord)
				<td><?php $record = $longTestClassRecord->instances()->where('user_id', $student->id)->first();
					echo (($record == null) ? '' : $record->score);
				?></td>
				@endforeach
				
				@if ($othersCount == 0)
					<td></td>
				@endif
				@foreach ($othersClassRecords as $othersClassRecord)
				<td><?php $record = $othersClassRecord->instances()->where('user_id', $student->id)->first();
					echo (($record == null) ? '' : $record->score);
				?></td>
				@endforeach
			</tr>
			@endforeach
		</table>
	</div>
</div>
@endsection