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
     * @param string $url_topic
     * @param string $url_subtopic
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

        $backUrl = "/categories/" . $category->name . "/topics/" . $topic->name . "/subtopics/" . $subtopic->name;
        $generateUrl = "/categories/" . $category->name . "/topics/" . $topic->name . "/subtopics/" . $subtopic->name . "/questions/" . $question->id . "/instance";
        return $this->questionsService->showByType($question, $generateUrl, $backUrl);
    }

    /**
     * Show the form in creating questions
     *
     * @param QuestionCategory $category
     * @param string $url_topic
     * @param string $url_subtopic
     * @param string $url_type
     * @return \Illuminate\Http\Response
     */
    public function create(QuestionCategory $category, $url_topic, $url_subtopic, $url_type){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
		
		switch($url_type){
    		case 'multiple-choice':
    			$type = 'Multiple Choice';
                return view('questions.content.create-type.multiple-choice-quantity', compact('url_type', 'category', 'topic', 'subtopic', 'type'));
                break;
            case 'true-or-false':
                $type = 'True or False';
                return view('questions.content.create-type.true-or-false', compact('url_type', 'category', 'topic', 'subtopic', 'type'));
                break;
            case 'fill-in-the-blanks':
    			$type = 'Fill in the Blanks';
    			return view('questions.content.create-type.fill-in-the-blanks', compact('url_type', 'category', 'topic', 'subtopic', 'type'));
    			break;
    		case 'match-column-a-with-column-b':
    			$type = 'Match Column A with Column B';
                return view('questions.content.create', compact('url_type', 'category', 'topic', 'subtopic', 'type'));
    			break;
            case 'select-from-the-wordbox':
                $type = 'Select from the Wordbox';
                return view('questions.content.create', compact('url_type', 'category', 'topic', 'subtopic', 'type'));
                break;
    		default:
    			return redirect('/home');
    	}
    }

    /**
     * Store the question in the database
     *
     * @param QuestionCategory $category
     * @param string $url_topic
     * @param string $url_subtopic
     * @param string $url_type
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
                $question = $this->createQuestion($request, $type_id, $subtopic->id);
                $question->multipleChoice()->create(['text' => $request->input('right_answer'), 'is_right_answer' => '1']);
                $wrong_answers = $request->input('wrong_answers');
                foreach ($wrong_answers as $wrongAnswer){
                    $question->multipleChoice()->create(['text' => $wrongAnswer, 'is_right_answer' => '0']);
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
            case 'match-column-a-with-column-b':
            case 'select-from-the-wordbox':
                $question = $this->createQuestion($request, $type_id, $subtopic->id);
                flash()->success("Question successfully added");
                return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id);
                break;
            default:
                return redirect('/home');
        }
        flash()->success("Question successfully added");
        return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name);
    }

    /**
     * Show the form in editing a question
     *
     * @param QuestionCategory $category
     * @param string $url_topic
     * @param string $url_subtopic
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        return view('questions.content.edit', compact('category', 'topic', 'subtopic', 'question'));
    }

    /**
     * Update the question in the database
     *
     * @param QuestionCategory $category
     * @param string $url_topic
     * @param string $url_subtopic
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, Request $request){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        $question->update($request->all());
        flash()->success('Question successfully updated');
        return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id);
    }



    /**
     * Show the form in deleting a question
     *
     * @param QuestionCategory $category
     * @param string $url_topic
     * @param string $url_subtopic
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function showDeleteConfirmation(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        
        if ($question->user_id != Auth::user()->id){
            flash()->error("You cannot delete a question you haven't made!");
            return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name);
        } else {
            return view('questions.content.delete', compact('category', 'topic', 'subtopic', 'question'));
        }
    }

    /**
     * Delete the question in the database
     *
     * @param QuestionCategory $category
     * @param string $url_topic
     * @param string $url_subtopic
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

    public function showMoveConfirmation(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, $subtopics = [], $selectedCategory = null, $selectedTopic = null){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        $categories = QuestionCategory::where('name', '<>', 'Default Category')->get();
        $topics = [];
        foreach($categories as $category){
            $topic_arr = [];
            foreach($category->questionTopics as $questionTopic){
                if($questionTopic->name != 'Default Topic'){
                    $topic_arr[] = $questionTopic;
                }
            }
            $topics[$category->id] = $topic_arr;
        }
        return view('questions.content.move', compact('category', 'topic', 'subtopic', 'question', 'subtopics', 'selectedCategory', 'selectedTopic', 'categories', 'topics'));
    }

    public function postSearch(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, Request $request){
        $selectedCategory = QuestionCategory::find($request->input('category'));
        $selectedTopic = QuestionTopic::find($request->input('topic'));
        $subtopics = $selectedTopic->questionSubtopics->lists('name', 'id');
        return $this->showMoveConfirmation($category, $url_topic, $url_subtopic, $question, $subtopics, $selectedCategory, $selectedTopic);
    }

    public function move(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, Request $request){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
        $newSubtopicLocation = QuestionSubtopic::find($request->input('question_subtopic_id'));
        $question->move($newSubtopicLocation->questionTopic->questionCategory->name, $newSubtopicLocation->questionTopic->name, $newSubtopicLocation->name);
        return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name);
    }

    /**
     * Show the form in creating questions
     *
     * @param string $type
     * @return array
     */
    private function fetchRules($type){
    	switch($type){
    		case 'common':
    			return [
    				'title' => 'required',
		    		'body' => 'required',
    			];
    			break;
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
     * @param int $type_id
     * @param int $subtopic_id 
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
