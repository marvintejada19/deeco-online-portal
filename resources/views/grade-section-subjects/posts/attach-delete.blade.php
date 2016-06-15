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
					{!! Form::open(['url' => 'posts/' . $post->id . '/attach/' . $attachment->id . '/delete/']) !!}
						<div class="form-group">
							{!! Form::label(null, 'Are you sure you want to delete this attachment?', ['class' => 'col-md-4 control-label']) !!}
							<blockquote>
								<table class="table table-bordered">
				                    <tr>
				                        <th>Subject name</th>
				                        <th>Section name</th>
				                        <th>Publish on</th>
				                    </tr>
				                    <tr>
				                        <td>{{ $attachment->gradeSectionSubject->subject->name }}</td>
				                        <td>{{ $attachment->gradeSectionSubject->gradeSection->getName->name }}</td>
				                        <td>{{ $attachment->getUnformattedDate('publish_on') }}</td>
				                    </tr>
								</table>
							</blockquote>
    					</div>
						{!! Form::submit('Delete attachment', ['class' => 'btn btn-danger']) !!}
						<input class="btn btn-primary" type="button" onclick="location.href='/posts/{{ $post->id }}'" value="Back">
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection