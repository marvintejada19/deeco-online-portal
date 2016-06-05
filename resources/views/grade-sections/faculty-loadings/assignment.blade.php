@extends('layouts.app')

@section('title')
	Assign faculty loadings to a grade section
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
					{!! Form::open(['url' => '/faculty-loadings/assignment']) !!}
					<td colspan="4">
						<select name="facultyId" class="form-control" required>
							<option value="" selected disabled>Select a faculty...</option>	
							@foreach ($facultyList as $faculty)
								@if (!is_null($facultySelected) && $faculty->id == $facultySelected->id)
								<option value="{{ $faculty->id }}" selected>{{ $faculty->getInfo()->lastname }}, {{ $faculty->getInfo()->firstname }}</option>
								@else
								<option value="{{ $faculty->id }}">{{ $faculty->getInfo()->lastname }}, {{ $faculty->getInfo()->firstname }}</option>
								@endif
							@endforeach
						</select>
					</td>
					<td>
						<button type="submit" class="btn btn-primary form-control">
							Select faculty
						</button>
					</td>
					{!! Form::close() !!}
				</tr>
				@if (isset($facultySelected))
				{!! Form::open(['url' => '/faculty-loadings/assignment/assign', 'name' => 'Assignment']) !!}
			    <tr>
			        <td colspan="2" style="width:40%">
			            {!! Form::label('Features', 'All Grade Section Subjects:', ['class' => 'col-md-4 control-label']) !!}
			            <select name="Features" size="20" MULTIPLE class="form-control">
			            @if (!empty($gradeSectionSubjects))
			            	@foreach ($gradeSectionSubjects as $gradeSectionSubject)
				                <option value="{{ $gradeSectionSubject->id }}">{{ $gradeSectionSubject->subject->name }} ({{ $gradeSectionSubject->gradeSection->getName->name }})</option>
							@endforeach
						@endif
			            </select>
			        </td>
			        <td colspan="1" align="center">
			        	<br><br><br><br><br><br>
			            <input type="Button" class="btn btn-default" value="Add >>" style="width:100px" onClick="SelectMoveRows(document.Assignment.Features,document.Assignment.FeatureCodes)" {{ isset($facultySelected) ? '' : 'disabled' }}>
			            <br><br>
			            <input type="Button" class="btn btn-default" value="<< Remove" style="width:100px" onClick="SelectMoveRows(document.Assignment.FeatureCodes,document.Assignment.Features)" {{ isset($facultySelected) ? '' : 'disabled' }}>
			        </td>
			        <td colspan="2" style="width:40%">
			        	{!! Form::label('FeatureCodes', 'Assigned Grade Section Subjects:', ['class' => 'col-md-4 control-label']) !!}
			            <select name="FeatureCodes" id="FeatureCodes" size="20" MULTIPLE class="form-control">
			            	@if (!empty($gradeSectionSubjectsAssignedToFaculty))
				            	@foreach ($gradeSectionSubjectsAssignedToFaculty as $gradeSectionSubject)
				            	<option value="{{ $gradeSectionSubject->id }}">{{ $gradeSectionSubject->subject->name }} ({{ $gradeSectionSubject->gradeSection->getName->name }})</option>
				            	@endforeach
				            @endif
			            </select>
			        </td>
			    </tr>
			    <tr>
			    	<td colspan="5">
			    		<button type="submit" class="btn btn-primary form-control" onclick="getSubjectList()" {{ isset($facultySelected) ? '' : 'disabled' }}>
							Update assignment status
						</button>
			    	</td>
			    </tr>
		    	<tr>
		    		<input type="hidden" id="assignList" name="assignList" value="">
		    		<input type="hidden" id="assignFaculty" name="assignFaculty" value="{{ $facultySelected->id or '' }}">
		    	</tr>
				{!! Form::close() !!}
				@endif
			</table>
		</div>
	</div>
</div>
@endsection