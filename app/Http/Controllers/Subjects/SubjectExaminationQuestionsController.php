<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Subjects\SubjectExamination;
use App\Models\Subjects\Subject;
use App\Models\Questions\QuestionCategory;
use App\Models\Questions\QuestionTopic;
use App\Models\Questions\QuestionSubtopic;
use App\Models\Questions\Question;
use App\Http\Services\QuestionsService;
use DB;
use URL;

class SubjectExaminationQuestionsController extends Controller
{
    private $questionsService;

    public function __construct(QuestionsService $questionsService){
        $this->questionsService = $questionsService;
    }

    public function search(Subject $subject, SubjectExamination $examination, $results = null){
    	if(session()->has('results')){
            $results = session()->get('results');
        }

        $categories = QuestionCategory::all();
    	$topics = [];
    	$subtopics = [];

    	foreach($categories as $category){
    		$topic_arr = [];
    		foreach($category->questionTopics as $topic){
    			$topic_arr[] = $topic;
    			$subtopic_arr = [];
    			foreach($topic->questionSubtopics as $subtopic){
    				$subtopic_arr[] = $subtopic;
    			}
    			$subtopics[$topic->id] = $subtopic_arr;
    		}
    		$topics[$category->id] = $topic_arr;
    	}

        $questions = $examination->questions->pluck('id');
        $questions_added = [];
        foreach ($questions as $question){
            $questions_added[] = $question;
        }
    	return view('subjects.examinations.questions.search', 
            compact('subject', 'examination', 'results', 'categories', 'topics', 'subtopics', 'questions_added'));
    }

    public function postSearch(Subject $subject, SubjectExamination $examination, Request $request){
        $results = [];

        if (!strcmp($request->input('category'), 'all')){
            $results = Question::all();    
        } else {
            $category = QuestionCategory::find($request->input('category'));
            if (!strcmp($request->input('topic'), 'all')){
                foreach ($category->questionTopics as $topic){
                    foreach($topic->questionSubtopics as $subtopics){
                        foreach($subtopics->questions as $question){
                            $results[] = $question;
                        }
                    }
                }
            } else {
                $topic = QuestionTopic::find($request->input('topic'));
                if (!strcmp($request->input('subtopic'), 'all')){
                    foreach($topic->questionSubtopics as $subtopics){
                        foreach($subtopics->questions as $question){
                            $results[] = $question;
                        }
                    }
                } else {
                    $subtopic = QuestionSubtopic::find($request->input('subtopic'));
                    foreach($subtopic->questions as $question){
                        $results[] = $question;
                    }
                }
            }
        }

        session()->put('results', $results);
        return $this->search($subject, $examination, $results);
    }

    public function add(Subject $subject, SubjectExamination $examination, Question $question, Request $request){
        $examination->questions()->attach($question);
        $results = session()->get('results');
        session()->put('results', $results);
        if (!strcmp($question->getQuestionType(), 'Matching Type')){
            $examination->total_points += $question->points * count($question->matchingType->matchingTypeItems);
        } else {
            $examination->total_points += $question->points;
        }
        $examination->update();
        return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/questions');
    }

    public function remove(Subject $subject, SubjectExamination $examination, Question $question, Request $request){
        $url = URL::previous();
        $questions = $examination->questions->pluck('id');
        $questions_added = [];
        foreach ($questions as $single_question){
            $questions_added[] = $single_question;
        }

        if (!in_array($question->id, $questions_added)){
            return redirect($url);
        } else {
            $examination->questions()->detach($question);
            $results = session()->get('results');
            session()->put('results', $results);
            if (!strcmp($question->getQuestionType(), 'Matching Type')){
                $examination->total_points -= $question->points * count($question->matchingType->matchingTypeItems);
            } else {
                $examination->total_points -= $question->points;
            }
            $examination->update();
            return redirect($url);
        }
    }

    public function list(Subject $subject, SubjectExamination $examination){
        return view('subjects.examinations.questions.list', compact('subject', 'examination'));
    }

    public function show(Subject $subject, SubjectExamination $examination, Question $question){
        $backUrl = '/subjects/' . $subject->id . '/examinations/' . $examination->id;
        $generateUrl = '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/questions/' . $question->id . '/instance';
        return $this->questionsService->showByType($question, $backUrl, $generateUrl);
    }

    public function generateInstance(Subject $subject, SubjectExamination $examination, Question $question){
        $navbar = "<ol class=\"breadcrumb pull-right\"><li><a href=\"/subjects/" . $subject->id . "/examinations/" . $examination->id . "/questions/" . $question->id . "\">Back</a></li></ol>";
        $nextUrl = '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/questions/' . $question->id . '/instance/results';
        return $this->questionsService->generateInstance($question, $navbar, $nextUrl);
    }

    public function processInstance(Subject $subject, SubjectExamination $examination, Question $question, Request $request){
        $nextUrl = '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/questions/' . $question->id;
        return $this->questionsService->processInstance($question, $nextUrl, $request);
    }
}
