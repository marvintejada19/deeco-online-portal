@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Current schoolyear: 
                    @if(is_null($activeSchoolYear))
                    <font color="orange">Undefined</font>
                    @else
                    <font color="yellow">{{ $activeSchoolYear->name }}</font>
                    @endif
                    <button type="button" class="btn btn-warning pull-right" onclick="">
                        Change schoolyear
                    </button>
                    <br></br>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button id='span_right_users_body' type="button" class="btn btn-default btn-xs" onclick="showhide('users_body', 1)" style="display:;">
                        <span class="glyphicon glyphicon-menu-right"></span>
                    </button>
                    <button id='span_down_users_body' type="button" class="btn btn-default btn-xs" onclick="showhide('users_body', 0)" style="display: none;">
                        <span class="glyphicon glyphicon-menu-down"></span>
                    </button>
                    Users
                </div>
                <div class="panel-body" id="users_body" style="display:none;">
                    <ul>
                        <li><a href="/users/create">Create a new user</a></li>
                        <hr/>
                        <li><a href="/users/school-management">View list of school management</a></li>
                        <li><a href="/users/faculty">View list of faculty</a></li>
                        <li><a href="/users/students">View list of students</a></li>
                        <hr/>
                        <li><a href="/users/enrollment">Assign students to a grade section</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button id='span_right_grade_sections_body' type="button" class="btn btn-default btn-xs" onclick="showhide('grade_sections_body', 1)" style="display:;">
                        <span class="glyphicon glyphicon-menu-right"></span>
                    </button>
                    <button id='span_down_grade_sections_body' type="button" class="btn btn-default btn-xs" onclick="showhide('grade_sections_body', 0)" style="display: none;">
                        <span class="glyphicon glyphicon-menu-down"></span>
                    </button>
                    Grade sections
                </div>
                <div class="panel-body" id="grade_sections_body" style="display:none;">
                    <ul>
                        <li><a href="/grade-sections">View list of grade sections</a></li>
                        <hr/>
                        <li><a href="/users/enrollment">Assign students to a grade section</a></li>
                        <li><a href="/grade-sections/subjects/assignment">Assign subjects to a grade section</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button id='span_right_faculty_loadings_body' type="button" class="btn btn-default btn-xs" onclick="showhide('faculty_loadings_body', 1)" style="display:;">
                        <span class="glyphicon glyphicon-menu-right"></span>
                    </button>
                    <button id='span_down_faculty_loadings_body' type="button" class="btn btn-default btn-xs" onclick="showhide('faculty_loadings_body', 0)" style="display: none;">
                        <span class="glyphicon glyphicon-menu-down"></span>
                    </button>
                    Faculty Loadings
                </div>
                <div class="panel-body" id="faculty_loadings_body" style="display:none;">
                    <ul>
                        <li><a href="/faculty-loadings">View list of faculty loadings</a></li>
                        <hr/>
                        <li><a href="/faculty-loadings/assignment">Assign grade section subjects to a faculty</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button id='span_right_others_body' type="button" class="btn btn-default btn-xs" onclick="showhide('others_body', 1)" style="display:;">
                        <span class="glyphicon glyphicon-menu-right"></span>
                    </button>
                    <button id='span_down_others_body' type="button" class="btn btn-default btn-xs" onclick="showhide('others_body', 0)" style="display: none;">
                        <span class="glyphicon glyphicon-menu-down"></span>
                    </button>
                    Others
                </div>
                <div class="panel-body" id="others_body" style="display:none;">
                    <ul>
                        <li><a href="/others/subjects/create">Create a new subject</a></li>
                        <li><a href="/others/subjects">View list of subjects</a></li>
                        <hr/>
                        <li><a href="/others/school-years/create">Create a new school year</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button id='span_right_announcements_body' type="button" class="btn btn-default btn-xs" onclick="showhide('announcements_body', 1)" style="display:;">
                        <span class="glyphicon glyphicon-menu-right"></span>
                    </button>
                    <button id='span_down_announcements_body' type="button" class="btn btn-default btn-xs" onclick="showhide('announcements_body', 0)" style="display: none;">
                        <span class="glyphicon glyphicon-menu-down"></span>
                    </button>
                    Announcements
                </div>
                <div class="panel-body" id="announcements_body" style="display:none;">
                    <ul>
                        <li><a href="#">Create a new announcement</a></li>
                        <hr/>
                        <li><a href="#">See list of announcements</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function showhide(id, counter) {
        var e = document.getElementById(id);
        e.style.display = (e.style.display == 'block') ? 'none' : 'block';

        if(counter){
            var spanId = 'span_right_' + id;
            document.getElementById(spanId).style.display = 'none';
            var spanId2 = 'span_down_' + id; 
            document.getElementById(spanId2).style.display = '';
        } else {
            var spanId = 'span_down_' + id; 
            document.getElementById(spanId).style.display = 'none';
            var spanId2 = 'span_right_' + id; 
            document.getElementById(spanId2).style.display = '';
        }
   }
</script>
@stop