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
        $classRecordsInQuarter = [];
        for ($i = 1; $i < 5; $i++){
            $allClassRecords = SubjectClassRecord::where('grade_section_subject_id', $gradeSectionSubject->id);
            $classRecordsPerQuarter = $allClassRecords->where('quarter', $i)->get();
            $classRecords = [];
            $seatworkClassRecords = [];
            $homeworkClassRecords = [];
            $quizClassRecords = [];
            $longTestClassRecords = [];
            $othersClassRecords = [];
            
            foreach ($classRecordsPerQuarter as $classRecord){
                $subcategory = $classRecord->deployment->examination->subcategory;
                switch ($subcategory){
                    case 'Seatwork':
                        $seatworkClassRecords[] = $classRecord;
                        break;
                    case 'Homework':
                        $homeworkClassRecords[] = $classRecord;
                        break;
                    case 'Quiz':
                        $quizClassRecords[] = $classRecord;
                        break;
                    case 'Long test':
                        $longTestClassRecords[] = $classRecord;
                        break;
                    case 'Others':
                        $othersClassRecords[] = $classRecord;
                        break;
                }
            }
            $classRecords['Seatwork'] = $seatworkClassRecords;
            $classRecords['Homework'] = $homeworkClassRecords;
            $classRecords['Quiz'] = $quizClassRecords;
            $classRecords['Long test'] = $longTestClassRecords;
            $classRecords['Others'] = $othersClassRecords;

            $classRecordsInQuarter[$i] = $classRecords;
        }

        $students = $gradeSectionSubject->gradeSection->students;
        foreach ($students as $student){
            if ($student->getInfo()->gender == 1){
                $maleStudents[$student->getFullName()] = $student;
            } else {
                $femaleStudents[$student->getFullName()] = $student;
            }
        }
        ksort($maleStudents);
        ksort($femaleStudents);
        return view('grade-section-subjects.content.class-record', compact('gradeSectionSubject', 'classRecordsInQuarter', 'maleStudents', 'femaleStudents'));
    }
}
