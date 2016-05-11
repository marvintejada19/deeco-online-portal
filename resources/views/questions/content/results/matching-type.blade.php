@extends('questions.content.results.layout')

@section('instance-form')
	<div>
		<table class="table">
			<tr>
				<td colspan="2">
				<table class="table table-bordered">
		            <tr>
		            	<th></th>
		            	<th>Your answer</th>
		            	<th>Correct answer</th>
		            </tr>
		        	@foreach ($items as $item)
		            <tr>
		            	<th>{{ $item->text }}</th> 
		            	<td class="{{ (!strcmp($answers[$item->id], $item->correct_answer)) ? 'bg-success' : 'bg-danger' }}">
		            		{{ $answers[$item->id] }}
		            	</td>
		            	<td class="bg-info">{{ $item->correct_answer }}</td>
		            </tr>
		        	@endforeach
		        </table>
		       	<td>
		    </tr>
            <tr>
	            <th>Total points</th>
	            <td>{{ $points }}</td>
	        </tr>
        </table>
	</div>
@endsection