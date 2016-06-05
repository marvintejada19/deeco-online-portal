<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Services\SubjectArticlesService;
use App\Models\GradeSectionSubjects\GradeSectionSubject;
use App\Models\GradeSectionSubjects\SubjectClassRecord;
use App\Models\GradeSectionSubjects\SubjectClassRecordInstance;

class GradeSectionSubjectsController extends Controller
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

    public function show(GradeSectionSubject $gradeSectionSubject){
    	$articles = $this->subjectArticlesService->sortArticles($gradeSectionSubject);
        $types = session()->pull('types');
        $is_teacher = true;
    	return view('grade-section-subjects.content.show', compact('gradeSectionSubject', 'articles', 'types', 'is_teacher'));
    }

    /**
     * Show the details of the given class
     *
     * @param GradeSectionSubject $gradeSectionSubject
     * @return \Illuminate\Http\Response
     */
    public function showDetails(GradeSectionSubject $gradeSectionSubject){
        return view('grade-section-subjects.content.details', compact('gradeSectionSubject'));
    }

    public function showClassRecord(GradeSectionSubject $gradeSectionSubject){
        $seatworkClassRecords = [];
        $homeworkClassRecords = [];
        $quizClassRecords = [];
        $longTestClassRecords = [];
        $othersClassRecords = [];
        $classRecords = SubjectClassRecord::where('grade_section_subject_id', $gradeSectionSubject->id)->get();
        foreach ($classRecords as $classRecord){
            $subcategory = $classRecord->examination->subcategory;
            if (!strcmp($subcategory, 'Quiz')){
                $quizClassRecords[] = $classRecord;
            } else if (!strcmp($subcategory, 'Long test')){
                $longTestClassRecords[] = $classRecord;
            } else if (!strcmp($subcategory, 'Others')){
                $othersClassRecords[] = $classRecord;
            } else if (!strcmp($subcategory, 'Seatwork')){
                $seatworkClassRecords = $classRecord;
            } else if (!strcmp($subcategory, 'Homework')){
                $homeworkClassRecords = $classRecord;
            }
        }

        $quizCount = count($quizClassRecords);
        $longTestCount = count($longTestClassRecords);
        $othersCount = count($othersClassRecords);
        $seatworkCount = count($seatworkClassRecords);
        $homeworkCount = count($homeworkClassRecords);
        $students = $gradeSectionSubject->gradeSection->students;
        
        return view('grade-section-subjects.content.class-record', compact('gradeSectionSubject', 'seatworkClassRecords', 'homeworkClassRecords', 'quizClassRecords', 'longTestClassRecords', 'othersClassRecords', 
            'classRecords', 'seatworkCount', 'homeworkCount', 'quizCount', 'longTestCount', 'othersCount', 'students'));
    }
}
