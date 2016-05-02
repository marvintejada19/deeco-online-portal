@extends('layouts.app')

@section('title')
	Add questions
@endsection

@section('content')
<div class="container">
	@include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title}}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations">All examinations</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}">{{ $examination->title }}</a></li>
        <li class="active">Add/remove questions</li>
    </ol>
    <br></br><hr/>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
            <div class="panel-heading">Search questions</div>
				<table class="table">
            	{!! Form::open(['url' => 'subjects/' . $subject->id . '/examinations/' . $examination->id . '/questions']) !!}	
					<tr>
						<th>Category</th>
						<th>Topic</th>
						<th>Subtopic</th>
					</tr>

					<tr>
						<td>
							<select name="category" id="category_ddl" onchange="configureTopicDropDownLists()" class="form-control" required>
								<option value="all" selected>All categories</option>
								@foreach ($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
								@endforeach
							</select>
						</td>

						<td>
							<select name="topic" id="topic_ddl" onchange="configureSubtopicDropDownLists()" class="form-control">
								<option value="all" selected>All topics</option>
							</select>
						</td>
						<td>
							<select name="subtopic" id="subtopic_0" class="form-control">
								<option value="all" selected>All subtopics</option>
							</select>

							@foreach ($subtopics as $topicId => $subtopics)
							<select name="subtopic" id="subtopic_{{ $topicId }}" class="form-control" disabled style="display:none">
								<option value="all" selected>All subtopics</option>
								@foreach ($subtopics as $subtopic)
								<option value="{{ $subtopic->id }}">{{ $subtopic->name }}</option>
								@endforeach
							</select>
							@endforeach
						</td>
					</tr>

					<tr>
						<td></td>
						<td></td>
						<td>
							<div class="pull-right">
								<button type="submit" class="btn btn-primary">
									<span class="glyphicon glyphicon-search"></span> Search
	                    		</button>
	                    		&nbsp;&nbsp;&nbsp;
	                    		<div class="dropdown pull-right">
	                                <button class="btn btn-default dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	                                    <span class="caret"></span>
	                                </button>
	                                <ul class="dropdown-menu" aria-labelledby="dLabel">
	                                	<li><a class="bg-info" href="/categories/subjects/{{ $subject->id }}">View all categories</a></li>
	                                </ul>
	                            </div>
	                    	</div>
						</td>
					</tr>
				{!! Form::close() !!}
				</table>
			</div>
		</div>
	</div>

	@include('subjects.examinations.questions.results')
</div>

<script type="text/javascript">
	var subtopicId = 0;

	function configureTopicDropDownLists() {
		ddl1 = document.getElementById('category_ddl');
		ddl2 = document.getElementById('topic_ddl');

		switch (ddl1.value) {
	    	<?php 
			foreach ($categories as $category){
				echo "case '" . $category->id . "': " .
						"ddl2.options.length = 0; " .
						"var opt0 = document.createElement('option'); " .
						"opt0.selected = true; " .
						"opt0.text = 'All topics'; " .
						"opt0.value = 'all'; " .
						"ddl2.options.add(opt0); ";
				foreach ($topics[$category->id] as $topic){
				echo 	"var opt = document.createElement('option'); " .
						"opt.value = '" . $topic->id . "'; " .
						"opt.text = '" . $topic->name . "'; " .
						"ddl2.options.add(opt);";
				}
				echo 	"break;";
			}
	    	?>
	    	case 'all':
	    		ddl2.options.length = 0;
				var opt0 = document.createElement('option');
				opt0.selected = true; 
				opt0.text = 'All topics'; 
				opt0.value = 'all'; 
				ddl2.options.add(opt0); ;
	    		break;
	    	default:
	    		ddl2.options.length = 0;
	    }

	    resetSubtopicDropDownLists();
	}

	function configureSubtopicDropDownLists(){
		ddl1 = document.getElementById("topic_ddl");
		if(ddl1.value == "all"){
			resetSubtopicDropDownLists();
		} else {
			ddl_hide = document.getElementById("subtopic_" + subtopicId);
			ddl_show = document.getElementById("subtopic_" + ddl1.value);

			ddl_hide.style.display = 'none';
			ddl_hide.disabled = true;
			ddl_show.style.display = '';
			ddl_show.disabled = false;

			subtopicId = ddl1.value;
		}
	}

	function resetSubtopicDropDownLists(){
		ddl_hide = document.getElementById("subtopic_" + subtopicId);
		ddl_show = document.getElementById("subtopic_" + 0);

		ddl_hide.style.display = 'none';
		ddl_hide.disabled = true;
		ddl_show.style.display = '';
		ddl_show.disabled = false;

		subtopicId = 0;
	}
</script>
@endsection