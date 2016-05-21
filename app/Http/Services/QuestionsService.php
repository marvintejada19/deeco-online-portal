<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Questions\Question;
use App\Models\Questions\Types\QuestionMultipleChoice;
use App\Models\Questions\Types\QuestionTrueOrFalse;
use App\Models\Questions\Types\QuestionFillInTheBlanks;
use App\Models\Questions\Types\QuestionMatchColumnsChoice;
use App\Models\Questions\Types\QuestionMatchColumnsItem;
use App\Models\Questions\Types\QuestionSelectFromTheWordboxChoice;
use App\Models\Questions\Types\QuestionSelectFromTheWordboxItem;
use App\Models\Subjects\SubjectExaminationAnswer;
use Illuminate\Foundation\Validation\ValidatesRequests;

class QuestionsService
{
    use ValidatesRequests;

    /**
     * Request a file upload and create records in the database
     *
     * @param Question $question
     * @param $generateUrl a string specifying the URL of the 'generated question'
     * @return \Illuminate\Http\Response
     */
    public function showByType(Question $question, $generateUrl, $backUrl){
        switch($question->getQuestionType()){
            case 'Multiple Choice':
                $rightAnswer = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '1')->first()->text;
                $wrongAnswers = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '0')->orderBy('text', 'asc')->get();
                return view('questions.content.show-partials.multiple-choice', compact('question', 'backUrl', 'generateUrl', 'rightAnswer', 'wrongAnswers'));
                break;
            case 'True or False':
                $rightAnswer = QuestionTrueOrFalse::where('question_id', $question->id)->first()->right_answer;
                return view('questions.content.show-partials.true-or-false', compact('question', 'backUrl', 'generateUrl', 'rightAnswer'));
                break;
            case 'Fill in the Blanks':
                $rightAnswer = QuestionFillInTheBlanks::where('question_id', $question->id)->first()->right_answer;
                return view('questions.content.show-partials.fill-in-the-blanks', compact('question', 'backUrl', 'generateUrl', 'rightAnswer'));
                break;
            case 'Match Column A with Column B':
                $choices = QuestionMatchColumnsChoice::where('question_id', $question->id)->get();
                $items = [];
                foreach ($choices as $choice){
                    $items[$choice->id] = QuestionMatchColumnsItem::where('columns_choice_id', $choice->id)->first();
                }
                return view('questions.content.show-partials.match-column-a-with-column-b', compact('question', 'backUrl', 'generateUrl', 'choices', 'items'));
                break;
            case 'Select from the Wordbox':
                $choices = QuestionSelectFromTheWordboxChoice::where('question_id', $question->id)->get();
                $noItems = true;
                $items = [];
                foreach ($choices as $choice){
                    $query_items = QuestionSelectFromTheWordboxItem::where('wordbox_choice_id', $choice->id)->get();
                    $items[$choice->id] = $query_items;
                    if(!($query_items->isEmpty())){
                        $noItems = false;
                    }
                }
                return view('questions.content.show-partials.select-from-the-wordbox', compact('question', 'backUrl', 'generateUrl', 'choices', 'items', 'noItems'));
                break;
            default:
                flash()->error('Some error occurred. Please try again.');
                return redirect('/home');
        }
    }

    /**
     * Generate an instance of the question
     *
     * @param $question an instance of Question
     * @param $navbar a string that contains the html code for constructing the navbar
     * @param $nextUrl a string specifying the next Url requested upon submission of answers
     * @param $fromExam false by default, specifies whether the previous request came from an exam instance or a generated instance
     * @param $answerCollection nullable, contains the answers, if those exist, to the given question
     * @return \Illuminate\Http\Response
     */
    public function generateInstance($question, $navbar, $nextUrl, $fromExam = false, $answerCollection = null){
        $answer = $answerCollection;
        switch($question->getQuestionType()){
            case 'Multiple Choice':
                $choices = QuestionMultipleChoice::where('question_id', $question->id)->get()->shuffle();
                if ($fromExam && !($answerCollection->isEmpty())){
                    $answer = $answerCollection->first()->answer;
                } else {
                    $answer = '';
                }
                return view('questions.content.instances.multiple-choice', compact('question', 'navbar', 'nextUrl', 'choices', 'answer'));
                break;
            case 'True or False':
                if ($fromExam && !($answerCollection->isEmpty())){
                    $answer = $answerCollection->first()->answer;
                } else {
                    $answer = '';
                }
                return view('questions.content.instances.true-or-false', compact('question', 'navbar', 'nextUrl', 'answer'));
                break;
            case 'Fill in the Blanks':
                if ($fromExam && !($answerCollection->isEmpty())){
                    $answer = $answerCollection->first()->answer;
                } else {
                    $answer = '';
                }
                return view('questions.content.instances.fill-in-the-blanks', compact('question', 'navbar', 'nextUrl', 'answer'));
                break;
            // case 'Matching Type':
            //     $answers = [];
            //     $format = $question->matchingType->format;
            //     $choices = QuestionMatchingTypeChoices::where('matching_type_id', $question->matchingType->id)->get()->shuffle()->pluck('text');
            //     $items = QuestionMatchingTypeItems::where('matching_type_id', $question->matchingType->id)->get()->shuffle();
            //     if($fromExam && !($answerCollection->isEmpty())){
            //         foreach ($answerCollection as $answerPerItem){
            //             $answers[$answerPerItem->matching_type_item_id] = $answerPerItem->answer;
            //         }
            //     }
            //     if (!strcmp($format, 'columns')) {
            //         return view('questions.content.instances.matching-type-columns', compact('question', 'navbar', 'nextUrl', 'answers', 'choices', 'items'));
            //     } else if (!strcmp($format, 'wordbox')) {
            //         return view('questions.content.instances.matching-type-wordbox', compact('question', 'navbar', 'nextUrl', 'answers', 'choices', 'items'));
            //     } else {
            //         return redirect('/home');
            //     }
            //     break;
            default:
                flash()->error('Some error occurred. Please try again.');
                return redirect('/home');
        }
    }

    /**
     * Process the question instance
     *
     * @param $question an instance of Question
     * @param $nextUrl a string specifying the next Url requested after processing the answers
     * @param \Illuminate\Http\Request $request
     * @param $fromExam false by default, specifies whether the previous request came from an exam instance or a generated instance
     * @param $instance an instance of Examination Instance
     * @return \Illuminate\Http\Response
     */
    public function processInstance($question, $nextUrl, $request, $fromExam = false, $instance = null){
        switch($question->getQuestionType()){
            case 'Multiple Choice':
                $this->validate($request, ['answer' => 'required'], ['answer.required' => 'Please answer the question.']);
                $answer = QuestionMultipleChoice::find($request->input('answer'))->text;
                $correctAnswer = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '1')->first()->text;
                $points = (!strcmp($answer, $correctAnswer)) ? $question->points : 0;
                if ($fromExam){
                    $this->recordAnswer($instance, $question, $answer);
                    return redirect($nextUrl);
                } else {
                    return view('questions.content.results.multiple-choice', compact('question', 'nextUrl', 'answer', 'correctAnswer', 'points'));
                }
                break;
            case 'True or False':
                $this->validate($request, ['answer' => 'required'], ['answer.required' => 'Please answer the question.']);
                $answer = $request->input('answer');
                $correctAnswer = QuestionTrueOrFalse::where('question_id', $question->id)->first()->right_answer;
                $points = (!strcmp($answer, $correctAnswer)) ? $question->points : 0;
                if ($fromExam){
                    $this->recordAnswer($instance, $question, $answer);
                    return redirect($nextUrl);
                } else {
                    return view('questions.content.results.true-or-false', compact('question', 'nextUrl', 'answer', 'correctAnswer', 'points'));
                }
                break;
            case 'Fill in the Blanks':
                $this->validate($request, ['answer' => 'max:255'], ['answer.required' => 'Please answer the question.']);
                $answer = $request->input('answer');
                $correctAnswer = QuestionFillInTheBlanks::where('question_id', $question->id)->first()->right_answer;
                $points = (!strcmp($answer, $correctAnswer)) ? $question->points : 0;
                if ($fromExam){
                    $this->recordAnswer($instance, $question, $answer);
                    return redirect($nextUrl);
                } else {
                    return view('questions.content.results.fill-in-the-blanks', compact('question', 'nextUrl', 'answer', 'correctAnswer', 'points'));
                }
                break;
            // case 'Matching Type':
            //     $answers = $request->input('answers');
            //     $items = QuestionMatchingTypeItems::where('matching_type_id', $question->matchingType->id)->get();
            //     $points = 0;
            //     foreach ($answers as $itemId => $answer){
            //         $item = QuestionMatchingTypeItems::where('id', $itemId)->first();
            //         $points += (!strcmp($answer, $item->correct_answer)) ? $question->points : 0;
            //     }
            //     if ($fromExam){
            //         foreach($answers as $itemId => $answer){
            //             $this->recordAnswer($instance, $question, $answer, $itemId);
            //         }
            //         return redirect($nextUrl);
            //     } else {
            //         return view('questions.content.results.matching-type', compact('question', 'nextUrl', 'answers', 'items', 'points'));
            //     }
            //     break;
            default:
                flash()->error('Some error occurred. Please try again.');
                return redirect('/home');    
        }
    }

    /**
     * Checks if the number of questions available in the given subtopic with the given 
     * question type is equal or greater than the supplied quantity 
     *
     * @param integer $questionTypeId
     * @param integer $subtopicId
     * @param integer $quantity
     * @return boolean 
     */
    public function verifyQuestionQuantityInSubtopic($questionTypeId, $subtopicId, $quantity){
        $count = count(Question::where('question_type_id', $questionTypeId)->where('question_subtopic_id', $subtopicId)->get());
        return (($quantity <= $count) ? true : false);
    }

    /**
     * Record the submitted answers
     *
     * @param $instance an instance of Examination Instance
     * @param $question an instance of Question
     * @param $answer a string specifying the answer submitted
     * @param $matching_type_id nullable, only has value when the question is a matching type
     * @return void
     */
    private function recordAnswer($instance, $question, $answer, $matching_type_item_id = null){
        $examinationAnswer = new SubjectExaminationAnswer();
        $examinationAnswer->examination_instance_id = $instance->id;
        $examinationAnswer->question_id = $question->id;
        $examinationAnswer->answer = $answer;
        if (!strcmp($question->getQuestionType(), 'Matching Type')){
            $examinationAnswer->matching_type_item_id = $matching_type_item_id;
        }
        $examinationAnswer->save();
    }       
}
