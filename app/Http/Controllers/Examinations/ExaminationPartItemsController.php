<?php

namespace App\Http\Controllers\Examinations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Services\QuestionsService;
use App\Models\Questions\Question;
use App\Models\Questions\QuestionCategory;
use App\Models\Questions\QuestionTopic;
use App\Models\Questions\QuestionSubtopic;
use App\Models\Examinations\Examination;
use App\Models\Examinations\ExaminationPart;
use App\Models\Examinations\ExaminationPartItem;

class ExaminationPartItemsController extends Controller
{
    private $questionsService;

    public function __construct(QuestionsService $questionsService){
        $this->questionsService = $questionsService;
    }

    public function create(Examination $examination, ExaminationPart $part, $subtopics = [], $questions = [], $selectedCategory = null, $selectedTopic = null, $questionCount = []){
    	$categories = QuestionCategory::where('name', '<>', 'Default Category')->get();
    	$topics = [];
		foreach($categories as $category){
    		$topic_arr = [];
	    	foreach($category->questionTopics as $topic){
                if($topic->name != 'Default Topic'){
                    $topic_arr[] = $topic;
                }
			}
    		$topics[$category->id] = $topic_arr;
    	}
    	return view('grade-section-subjects.examinations.parts.items.create', compact('examination', 'part', 'categories', 'topics', 'subtopics', 'questions', 'selectedCategory', 'selectedTopic', 'questionCount'));
    }

    public function postCreateSearch(Examination $examination, ExaminationPart $part, Request $request){
        $subtopics = QuestionSubtopic::where('name', '<>', 'Default Subtopic')->where('question_topic_id', $request->input('topic'))->lists('name', 'id');
        $subtopicList = QuestionSubtopic::where('question_topic_id', $request->input('topic'))->get();
    	$questions = [];
        $questionCount = [];
        foreach($subtopicList as $subtopic){
            $question_arr = [];
            $questionList = $subtopic->questions()->where('question_type_id', $part->question_type_id)->get();
            $questionCount[$subtopic->id] = count($questionList);
            foreach($questionList as $question){
                $question_arr[] = $question;
            }
            $questions[$subtopic->id] = $question_arr;
        }
        $selectedCategory = QuestionCategory::find($request->input('category'));
        $selectedTopic = QuestionTopic::find($request->input('topic'));
        return $this->create($examination, $part, $subtopics, $questions, $selectedCategory, $selectedTopic, $questionCount);
    }

    public function store(Examination $examination, ExaminationPart $part, Request $request){
    	$questionTypeId = $part->question_type_id;
    	$subtopicId = $request->input('question_subtopic_id');
        $quantity = $request->input('quantity');
        if(!strcmp($part->getQuestionType(), 'Select from the Wordbox') || !strcmp($part->getQuestionType(), 'Match Column A with Column B')){
            $currentItem = $part->items()->first();
            if ($currentItem != null){
                $currentItem->delete();
            }
            $choices_quantity = $request->input('choices_quantity');
            $question_id = $request->input('question_id');
            $part->items()->create($request->all());
            return redirect('/examinations/' . $examination->id . '/parts/' . $part->id);
        } else if($this->questionsService->verifyQuestionQuantityInSubtopic($questionTypeId, $subtopicId, $quantity)){
            $part->items()->create($request->all());
            return redirect('/examinations/' . $examination->id . '/parts/' . $part->id);
    	} else {
    		flash()->error('Cannot create this item. The number of questions in the database satisfying the conditions is less than the quantity you demand. 
    			Create more questions first or choose another subtopic.');
    		return redirect('/examinations/' . $examination->id . '/parts/' . $part->id . '/items/create');
    	}
    }

    public function showDeleteConfirmation(Examination $examination, ExaminationPart $part, $item_id){
        $item = ExaminationPartItem::find($item_id);
        return view('grade-section-subjects.examinations.parts.items.delete', compact('examination', 'part', 'item'));
    }

    public function delete(Examination $examination, ExaminationPart $part, $item_id){
        $item = ExaminationPartItem::find($item_id);
        $item->delete();
        return redirect('/examinations/' . $examination->id . '/parts/' . $part->id);
    }
}
