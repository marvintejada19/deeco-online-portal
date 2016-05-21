@extends('layouts.app')

@section('title')
	Create new examination part item
@endsection

@section('content')
<div class="container">
	@include('flash::message')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create new examination part item</div>
				<div class="panel-body">
					@include('subjects.examinations.parts.items.search')

					{!! Form::model($item = new \App\Models\Subjects\SubjectExaminationPartItem, ['url' => 'subjects/' . $subject->id . '/examinations/' . $examination->id . '/parts/' . $part->id . '/items']) !!}
						@include('subjects.examinations.parts.items.form', ['submitButtonText' => 'Add item'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function configureTopicDropDownLists() {
		ddl1 = document.getElementById('category_ddl');
		ddl2 = document.getElementById('topic_ddl');

		switch (ddl1.value) {
	    	<?php 
			foreach ($categories as $category){
				echo "case '" . $category->id . "': " .
						"ddl2.options.length = 0; ".
						"var opt0 = document.createElement('option'); ";
				foreach ($topics[$category->id] as $topic){
				echo 	"var opt = document.createElement('option'); " .
						"opt.value = '" . $topic->id . "'; " .
						"opt.text = '" . $topic->name . "'; " .
						"ddl2.options.add(opt);";
				}
				echo 	"break;";
			}
	    	?>
	    	default:
	    		ddl2.options.length = 0;
	    }
	}
</script>
@endsection