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
                $rightAnswer = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '1')->first();
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
