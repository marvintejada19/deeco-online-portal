@extends('layouts.app')

@section('title')
	Delete attachment
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete attachment</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'examinations/' . $examination->id . '/attach/' . $attachment->id . '/delete/']) !!}
						<div class="form-group">
							{!! Form::label(null, 'Are you sure you want to delete this attachment?', ['class' => 'col-md-4 control-label']) !!}
							<blockquote>
								<table class="table table-bordered">
				                    <tr>
				                        <th style="width:10%">Subject name</th>
				                        <th style="width:10%">Section name</th>
				                        <th>Publish on</th>
				                        <th>Available to students from</th>
				                        <th>until</th>
				                    </tr>
				                    <tr>
				                        <td>{{ $attachment->gradeSectionSubject->subject->name }}</td>
				                        <td>{{ $attachment->gradeSectionSubject->gradeSection->getName->name }}</td>
				                        <td>{{ $attachment->getUnformattedDate('publish_on') }}</td>
				                        <td>{{ $attachment->getUnformattedDate('exam_start') }}</td>
				                        <td>{{ $attachment->getUnformattedDate('exam_end') }}</td>
				                    </tr>
								</table>
							</blockquote>
    					</div>
						{!! Form::submit('Delete attachment', ['class' => 'btn btn-danger']) !!}
						<input class="btn btn-primary" type="button" onclick="location.href='/examinations/{{ $examination->id }}'" value="Back">
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection