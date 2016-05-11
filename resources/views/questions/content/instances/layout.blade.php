@extends('layouts.app')

@section('title')
	Question
@endsection

@section('content')
<div class="container">
	{!! $navbar !!}
	<hr/>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
					<h4>{!! $question->body !!}</h4>
				</div>
				<div class="panel-body">
					{!! Form::open(['url' => $nextUrl]) !!}
						@yield('instance-form')
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection