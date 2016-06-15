@extends('layouts.app')

@section('title')
	Assign subjects to a grade section
@endsection

@section('content')
<div class="container">
	<ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Assignment</li>
    </ol>
    <br></br><hr/>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<script language="Javascript">
				function SelectMoveRows(SS1,SS2){
				    var SelID='';
				    var SelText='';
				    // Move rows from SS1 to SS2 from bottom to top
				    for (i=SS1.options.length - 1; i>=0; i--){
				        if (SS1.options[i].selected == true){
				            SelID=SS1.options[i].value;
				            SelText=SS1.options[i].text;
				            var newRow = new Option(SelText,SelID);
				            SS2.options[SS2.length]=newRow;
				            SS1.options[i]=null;
				        }
				    }
				    SelectSort(SS2);
				}

				function SelectSort(SelList){
				    var ID='';
				    var someText='';
				    for (x=0; x < SelList.length - 1; x++){
				        for (y=x + 1; y < SelList.length; y++){
				            if (SelList[x].text > SelList[y].text){
				                // Swap rows
				                ID=SelList[x].value;
				                someText=SelList[x].text;
				                SelList[x].value=SelList[y].value;
				                SelList[x].text=SelList[y].text;
				                SelList[y].value=ID;
				                SelList[y].text=someText;
				            }
				        }
				    }
				}

				function getSubjectList(){
					var select = document.getElementById('FeatureCodes');
					var result = [];
					var options = select.options;
					var opt;

					for (var i=0, iLen=options.length; i<iLen; i++) {
						opt = options[i];
						result.push(opt.value || opt.text);
					}
					var hiddenDiv = document.getElementById('assignList');
					hiddenDiv.value = result;
				}
			</script>
			<table class="table">
				<tr>
					{!! Form::open(['url' => '/grade-sections/subjects/assignment']) !!}
					<td colspan="4">
						<select name="gradeSectionId" class="form-control" required>
							<option value="" selected disabled>Select a grade section...</option>	
							@foreach ($gradeSections as $gradeSection)
								@if (!is_null($gradeSectionSelected) && $gradeSection->id == $gradeSectionSelected->id)
								<option value="{{ $gradeSection->id }}" selected>{{ $gradeSection->getName->getGradeLevel() }} - {{ $gradeSection->getName->name }}</option>
								@else
								<option value="{{ $gradeSection->id }}">{{ $gradeSection->getName->getGradeLevel() }} - {{ $gradeSection->getName->name }}</option>
								@endif
							@endforeach
						</select>
					</td>
					<td>
						<button type="submit" class="btn btn-primary form-control">
							Select grade section
						</button>
					</td>
					{!! Form::close() !!}
				</tr>
				@if (isset($gradeSectionSelected))
				{!! Form::open(['url' => '/grade-sections/subjects/assignment/assign', 'name' => 'Assignment']) !!}
			    <tr>
			        <td colspan="2" style="width:40%">
			            {!! Form::label('Features', 'All subjects:', ['class' => 'col-md-4 control-label']) !!}
			            <select name="Features" size="20" MULTIPLE class="form-control">
		            	@foreach ($subjects as $subject)
		            		@if (!in_array($subject->id, $subjectIdsAssignedInSection))
			                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
							@endif
						@endforeach
			            </select>
			        </td>
			        <td colspan="1" align="center">
			        	<br><br><br><br><br><br>
			            <input type="Button" class="btn btn-default" value="Add >>" style="width:100px" onClick="SelectMoveRows(document.Assignment.Features,document.Assignment.FeatureCodes)" {{ isset($gradeSectionSelected) ? '' : 'disabled' }}>
			            <br><br>
			            <input type="Button" class="btn btn-default" value="<< Remove" style="width:100px" onClick="SelectMoveRows(document.Assignment.FeatureCodes,document.Assignment.Features)" {{ isset($gradeSectionSelected) ? '' : 'disabled' }}>
			        </td>
			        <td colspan="2" style="width:40%">
			        	{!! Form::label('FeatureCodes', 'Assigned subjects:', ['class' => 'col-md-4 control-label']) !!}
			            <select name="FeatureCodes" id="FeatureCodes" size="20" MULTIPLE class="form-control">
			            	@if (!empty($subjectsAssignedInSection))
				            	@foreach ($subjectsAssignedInSection as $subject)
				            	<option value="{{ $subject->id }}">{{ $subject->name }}</option>
				            	@endforeach
				            @endif
			            </select>
			        </td>
			    </tr>
			    <tr>
			    	<td colspan="5">
			    		<button type="submit" class="btn btn-primary form-control" onclick="getSubjectList()" {{ isset($gradeSectionSelected) ? '' : 'disabled' }}>
							Update assignment status
						</button>
			    	</td>
			    </tr>
		    	<tr>
		    		<input type="hidden" id="assignList" name="assignList" value="">
		    		<input type="hidden" id="assignSection" name="assignSection" value="{{ $gradeSectionSelected->id or '' }}">
		    	</tr>
				{!! Form::close() !!}
				@endif
			</table>
		</div>
	</div>
</div>
@endsection