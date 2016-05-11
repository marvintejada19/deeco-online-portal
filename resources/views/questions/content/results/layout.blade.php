@extends('layouts.app')

@section('title')
	Results
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                	<h4>{!! $question->body !!}</h4>
                </div>
				<div class="panel-body">
					@yield('instance-form')

					<button type="button" class="btn btn-primary pull-right" onclick="location.href='{{ $nextUrl }}'">
                        Done
                    </button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection