<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Services\QuestionsService;
use App\Models\Questions\Question;
use App\Models\Questions\QuestionCategory;
use App\Models\Questions\QuestionSubtopic;
use App\Models\Subjects\Subject;
use App\Models\Subjects\SubjectExamination;
use App\Models\Subjects\SubjectExaminationPart;
use App\Models\Subjects\SubjectExaminationPartItem;

class SubjectExaminationPartItemsController extends Controller
{
    private $questionsService;

    public function __construct(QuestionsService $questionsService){
        $this->questionsService = $questionsService;
    }

    public function create(Subject $subject, SubjectExamination $examination, SubjectExaminationPart $part, $subtopics = [], $questions = []){
    	$categories = QuestionCategory::all();
    	$topics = [];
		foreach($categories as $category){
    		$topic_arr = [];
	    	foreach($category->questionTopics as $topic){
	    		$topic_arr[] = $topic;
			}
    		$topics[$category->id] = $topic_arr;
    	}
    	return view('subjects.examinations.parts.items.create', compact('subject', 'examination', 'part', 'categories', 'topics', 'subtopics', 'questions'));
    }

    public function postCreateSearch(Subject $subject, SubjectExamination $examination, SubjectExaminationPart $part, Request $request){
        $subtopics = QuestionSubtopic::where('question_topic_id', $request->input('topic'))->lists('name', 'id');
        $subtopicList = QuestionSubtopic::where('question_topic_id', $request->input('topic'))->get();
    	$questions = [];
        foreach($subtopicList as $subtopic){
            $question_arr = [];
            $questionList = $subtopic->questions()->where('question_type_id', $part->question_type_id)->get();
            foreach($questionList as $question){
                $question_arr[] = $question;
            }
            $questions[$subtopic->id] = $question_arr;
        }
        return $this->create($subject, $examination, $part, $subtopics, $questions);
    }

    public function store(Subject $subject, SubjectExamination $examination, SubjectExaminationPart $part, Request $request){
    	$questionTypeId = $part->question_type_id;
    	$subtopicId = $request->input('question_subtopic_id');
        $quantity = $request->input('quantity');
        if(!strcmp($part->getQuestionType(), 'Select from the Wordbox') || !strcmp($part->getQuestionType(), 'Match Column A with Column B')){
            $choices_quantity = $request->input('choices_quantity');
            $question_id = $request->input('question_id');
            $part->items()->create($request->all());
            return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/parts/' . $part->id);
        } else if($this->questionsService->verifyQuestionQuantityInSubtopic($questionTypeId, $subtopicId, $quantity)){
            $part->items()->create($request->all());
            return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/parts/' . $part->id);
    	} else {
    		flash()->error('Cannot create this item. The number of questions in the database satisfying the conditions is less than the quantity you demand. 
    			Create more questions first or choose another subtopic.');
    		return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/parts/' . $part->id . '/items/create');
    	}
    }

    public function showDeleteConfirmation(Subject $subject, SubjectExamination $examination, SubjectExaminationPart $part, $item_id){
        $item = SubjectExaminationPartItem::find($item_id);
        return view('subjects.examinations.parts.items.delete', compact('subject', 'examination', 'part', 'item'));
    }

    public function delete(Subject $subject, SubjectExamination $examination, SubjectExaminationPart $part, $item_id){
        $item = SubjectExaminationPartItem::find($item_id);
        $item->delete();
        return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/parts/' . $part->id);
    }
}
