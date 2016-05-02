@extends('questions.content.show')

@section('question-details')
<tr>
	<th>Type:</th>
	<td>{{ $question->getQuestionType() }} <span class="glyphicon glyphicon-question-sign"></span></td>
</tr>

<tr>
	<th>Right answer:</th>
	<td class="success">{{ $rightAnswer }}</td>
</tr>
@endsection