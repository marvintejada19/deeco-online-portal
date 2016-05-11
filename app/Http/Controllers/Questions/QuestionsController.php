<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Questions\QuestionCategory;
use App\Models\Questions\QuestionTopic;
use App\Models\Questions\QuestionSubtopic;
use App\Models\Questions\Question;
use App\Http\Services\QuestionsService;
use DB;
use Auth;

class QuestionsController extends Controller
{
    private $questionsService;

	public function __construct(QuestionsService $questionsService){
        $this->questionsService = $questionsService;
    }

    public function show(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

        $backUrl = "/categories/" . $category->name . "/topics/" . $topic->name . "/subtopics/" . $subtopic->name;
        $generateUrl = "/categories/" . $category->name . "/topics/" . $topic->name . "/subtopics/" . $subtopic->name . "/questions/" . $question->id . "/instance";
        return $this->questionsService->showByType($question, $backUrl, $generateUrl);
    }

    public function create(QuestionCategory $category, $url_topic, $url_subtopic, $url_type){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
		
		switch($url_type){
    		case 'multiple-choice':
    			$type = 'Multiple Choice';
                return view('questions.content.type.multiple-choice', compact('url_type', 'category', 'topic', 'subtopic', 'type'));
                break;
            case 'true-or-false':
                $type = 'True or False';
                return view('questions.content.type.true-or-false', compact('url_type', 'category', 'topic', 'subtopic', 'type'));
                break;
            case 'fill-in-the-blanks':
    			$type = 'Fill in the Blanks';
    			return view('questions.content.type.fill-in-the-blanks', compact('url_type', 'category', 'topic', 'subtopic', 'type'));
    			break;
    		case 'matching-type':
    			$type = 'Matching Type';
                return view('questions.content.type.matching-type', compact('url_type', 'category', 'topic', 'subtopic', 'type'));
    			break;
    		default:
    			return redirect('/home');
    	}
    }

    public function store(QuestionCategory $category, $url_topic, $url_subtopic, $url_type, Request $request){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

        $this->validate($request, $this->fetchRules('common'));
        $type_id = DB::table('question_types')->where('name', $request->input('type'))->first()->id;
        $rules = $this->fetchRules($url_type);

        switch($url_type){
            case 'multiple-choice':
                $this->validate($request, $rules);
                $wrongAnswers = explode("|", $request->input('wrong_answers'));
                if($wrongAnswers[0] == ''){
                    return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/create/' . $url_type)->withInput($request->all())->withErrors(['wrong_answers' => 'Must have at least one wrong choice.']);
                } else {
                    $question = $this->createQuestion($request, $type_id, $subtopic->id);
                    
                    $question->multipleChoice()->create(['text' => $request->input('right_answer'), 'is_right_answer' => '1']);
                    foreach ($wrongAnswers as $wrongAnswer){
                        $question->multipleChoice()->create(['text' => $wrongAnswer, 'is_right_answer' => '0']);
                    }
                }
                break;
            case 'true-or-false':
                $this->validate($request, $rules);
                $question = $this->createQuestion($request, $type_id, $subtopic->id);
                $question->trueOrFalse()->create($request->all());
                break;
            case 'fill-in-the-blanks':
                $this->validate($request, $rules);
                $question = $this->createQuestion($request, $type_id, $subtopic->id);
                $question->fillInTheBlanks()->create($request->all());
                break;
            case 'matching-type':
                $choices = explode("|", $request->input('choices'));
                $choices_lc = array_map('strtolower', $choices);
                $items = $request->input('items');
                $answers = $request->input('answers');

                if(count($items) == count($answers)){
                    foreach ($answers as $answer){
                        if(!in_array(strtolower($answer), $choices_lc)){
                            return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/create/' . $url_type)->withInput($request->all())->withErrors(['choices' => 'Must include all corresponding answers']);
                        }
                    }
                    $question = $this->createQuestion($request, $type_id, $subtopic->id);
                    $matchingType = $question->matchingType()->create(['format' => $request->input('format')]);
                    for ($i = 0; $i < count($items); $i++){
                        $matchingType->matchingTypeItems()->create(['text' => $items[$i], 'correct_answer' => $answers[$i]]);
                    }
                    foreach ($choices as $choice){
                        $matchingType->matchingTypeChoices()->create(['text' => $choice]);
                    }
                } else {
                    return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/create/' . $url_type)->withInput($request->all())->withErrors(['items' => 'Please fill out everything.']);
                }
                break;
            default:
                return redirect('/home');
                break;
        }

        flash()->success("Question successfully added");
        return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name);
    }

    public function generateInstance(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        
        $backUrl = '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id;
        $nextUrl = '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id . '/instance/results';
        return $this->questionsService->generateInstance($question, $backUrl, $nextUrl);
    }

    public function processInstance(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, Request $request){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        
        $nextUrl = '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id;
        return $this->questionsService->processInstance($question, $nextUrl, $request);
    }

    private function fetchRules($type){
    	switch($type){
    		case 'common':
    			return [
    				'title' => 'required',
		    		'body' => 'required',
		    		'points' => 'required|min:1',
    			];
    			break;
    		case 'multiple-choice':
    		case 'fill-in-the-blanks':
                return [
                    'right_answer' => 'required|max:255',

                ];
                break;
            case 'true-or-false':
                return [
                    'right_answer' => 'required|boolean',
                ];
                break;
            default:
                return [];
    	}
    }

    private function createQuestion($request, $type_id, $subtopic_id){
        $question = new Question($request->all());
        $question->question_type_id = $type_id;
        $question->question_subtopic_id = $subtopic_id;
        $question->user_id = Auth::user()->id;
        $question->save();
        return $question;
    }
}
