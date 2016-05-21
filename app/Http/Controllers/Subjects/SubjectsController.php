<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Subjects\SubjectRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\SubjectArticlesService;
use App\Models\User;
use App\Models\Subjects\Subject;
use App\Models\Subjects\Section;

class SubjectsController extends Controller
{
    private $subjectArticlesService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubjectArticlesService $subjectArticlesService){
        $this->subjectArticlesService = $subjectArticlesService;
    }

    /**
     * Show the menu concerning subjects and sections
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('subjects.content.index');
    }

    /**
     * Show the contents of the given class
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject){
        $articles = $this->subjectArticlesService->sortArticles($subject);
        $types = session()->pull('types');
        $is_teacher = true;
        return view('subjects.content.show', compact('subject', 'articles', 'types', 'is_teacher'));
    }

    /**
     * Show the details of the given class
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function showDetails(Subject $subject){
        return view('subjects.content.details', compact('subject'));
    }

    public function create(){
        $facultyList = User::where('role_id', '3')->orderBy('username', 'asc')->lists('username', 'id');
        $sectionList = Section::orderBy('grade_level', 'asc')->get();
        foreach ($sectionList as $section){
            $sections[$section->id] = $section->grade_level . '-' . $section->section_name;
        }
        return view('subjects.content.create', compact('facultyList', 'sections'));
    }

    public function store(SubjectRequest $request){
        Subject::create([
            'subject_title' => $request->input('subject_title'),
            'user_id'       => $request->input('user_id'),
            'section_id'    => $request->input('section_id'),
            'sy'            => $request->input('sy'),
        ]);
        return redirect('/subject-sections/list');
    }

    public function list(){
        $subjects = Subject::orderBy('subject_title', 'asc')->get();
        return view('subjects.content.list', compact('subjects'));
    }

    public function search($subjectResult = null){
        $sectionList = Section::get();
        $sections = [];
        foreach($sectionList as $section){
            $sections[$section->id] = $section->getName();
        }
        $subjects = [];
        foreach($sectionList as $section){
            $subject_arr = [];
            foreach($section->subjects as $subject){
                $subject_arr[] = $subject;
            }
            $subjects[$section->id] = $subject_arr;
        }
        return view('subjects.enrollment.index', compact('sections', 'subjects', 'subjectResult'));
    }

    public function postSearch(Request $request){
        $subjectResult = Subject::find($request->input('subject'));
        return $this->search($subjectResult);
    }

    public function addStudents(Subject $subject, $results = null){
        if(session()->has('results')){
            $results = session()->get('results');
        }
        $enrolledStudents = [];
        foreach ($subject->students as $student){
            $enrolledStudents[] = $student->id;
        }
        return view('subjects.enrollment.add', compact('subject', 'results', 'enrolledStudents'));
    }

    public function searchStudents(Subject $subject, Request $request){
        $results = User::where('role_id', 4)->where('username', 'LIKE', '%'.$request->input('query_text').'%')->get();
        session()->put('results', $results);
        return $this->addStudents($subject, $results);
    }

    public function add(Subject $subject, User $user){
        $subject->students()->attach($user);
        $subject->update();
        return redirect('/subject-sections/enrollment/' . $subject->id . '/add');
    }

    public function removeStudents(Subject $subject){
        return view('subjects.enrollment.remove', compact('subject'));
    }

    public function remove(Subject $subject, User $user){
        $subject->students()->detach($user);
        $subject->update();
        return redirect('/subject-sections/enrollment/' . $subject->id . '/remove');   
    }
}
