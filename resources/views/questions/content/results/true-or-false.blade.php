@extends('questions.content.results.layout')

@section('instance-form')
	<div>
		<table class="table">
            <tr>
            	<th>Your answer</th>
            	<td class="{{ (!strcmp($answer, $correctAnswer)) ? 'bg-success' : 'bg-danger' }}">
            		{{ ($answer == '1') ? 'True' : 'False' }}
            	</td>
            </tr>
            <tr>
	            <th>Correct answer</th>
	            <td class="bg-info">
	            	{{ ($correctAnswer == '1') ? 'True' : 'False' }}
	            </td>
            </tr>
            <tr>
	            <th>Total points</th>
	            <td>{{ $points }}</td>
	        </tr>
        </table>
	</div>
@endsection