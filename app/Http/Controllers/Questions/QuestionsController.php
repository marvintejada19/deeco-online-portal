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

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(QuestionsService $questionsService){
        $this->questionsService = $questionsService;
    }

    /**
     * Show the contents of the given question
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

        $backUrl = "/categories/" . $category->name . "/topics/" . $topic->name . "/subtopics/" . $subtopic->name;
        $generateUrl = "/categories/" . $category->name . "/topics/" . $topic->name . "/subtopics/" . $subtopic->name . "/questions/" . $question->id . "/instance";
        return $this->questionsService->showByType($question, $backUrl, $generateUrl);
    }

    /**
     * Show the form in creating questions
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @param $url_type a string specifying the type (Multiple choice, true or false, etc.) of the question
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store the question in the database
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @param $url_type a string specifying the type (Multiple choice, true or false, etc.) of the question
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form in deleting a question
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function showDeleteConfirmation(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        $inExam = DB::table('examination_answers')->where('question_id', $question->id)->first();
        if ($question->user_id != Auth::user()->id){
            flash()->error("You cannot edit/delete a question you haven't made!");
            return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name);
        } else if ($inExam){
            flash()->error('You cannot edit/delete a question that is used in an exam!');
            return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name);
        } else {
            return view('questions.content.delete', compact('category', 'topic', 'subtopic', 'question'));
        }
    }

    /**
     * Delete the question in the database
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function delete(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        $question->delete();
        flash()->success('Question successfully deleted');
        return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name);
    }

    /**
     * Generates an instance of the question
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function generateInstance(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        
        $backUrl = '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id;
        $nextUrl = '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id . '/instance/results';
        return $this->questionsService->generateInstance($question, $backUrl, $nextUrl);
    }

    /**
     * Process the submitted answers of the instance and output the results
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @param Question $question
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function processInstance(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, Request $request){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        
        $nextUrl = '/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id;
        return $this->questionsService->processInstance($question, $nextUrl, $request);
    }

    /**
     * Show the form in creating questions
     *
     * @param $type a string specifying the type (Multiple choice, true or false, etc.) of the question
     * @return array
     */
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

    /**
     * Creates a Question instance and stores it in the database
     *
     * @param \Illuminate\Http\Request $request
     * @param $type_id indicates the id of the given question type
     * @param $subtopic_id indicates the id of the given quesiton subtopic 
     * @return Question $question
     */
    private function createQuestion($request, $type_id, $subtopic_id){
        $question = new Question($request->all());
        $question->question_type_id = $type_id;
        $question->question_subtopic_id = $subtopic_id;
        $question->user_id = Auth::user()->id;
        $question->save();
        return $question;
    }
}
