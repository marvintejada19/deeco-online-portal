<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Questions\Question;
use App\Models\Questions\Types\QuestionMultipleChoice;
use App\Models\Questions\Types\QuestionTrueOrFalse;
use App\Models\Questions\Types\QuestionFillInTheBlanks;
use App\Models\Questions\Types\QuestionSelectFromTheWordboxChoice;
use App\Models\Questions\Types\QuestionSelectFromTheWordboxItem;
use App\Models\Questions\Types\QuestionMatchColumnsChoice;
use App\Models\Questions\Types\QuestionMatchColumnsItem;
use App\Models\Examinations\DeploymentAnswer;
use Auth;
use Response;
use URL;

class ExaminationsService
{
    public function generatePage($instancePart, $questions, $navbar, $submitUrl, $choices_quantity = 0){
        switch($instancePart->examinationPart->getQuestionType()){
            case 'Multiple Choice':
                $choices = [];
                $answers = [];
                foreach ($questions as $question){
                    $answer = $this->fetchAnswer($instancePart->id, $question->id);
                    $answers[$question->id] = ($answer == null) ? '' : $answer->answer;
                    $choices[$question->id] = QuestionMultipleChoice::where('question_id', $question->id)->get()->shuffle();
                }
                return view('grade-section-subjects.examinations.instances.multiple-choice', compact('instancePart', 'questions', 'navbar', 'submitUrl', 'choices', 'answers'));
                break;
            case 'True or False':
                $answers = [];
                foreach ($questions as $question){
                    $answer = $this->fetchAnswer($instancePart->id, $question->id);
                    $answers[$question->id] = ($answer == null) ? '' : $answer->answer;
                }
                return view('grade-section-subjects.examinations.instances.true-or-false', compact('instancePart', 'questions', 'navbar', 'submitUrl', 'answers'));
                break;
            case 'Fill in the Blanks':
                $answers = [];
                foreach ($questions as $question){
                    $answer = $this->fetchAnswer($instancePart->id, $question->id);
                    $answers[$question->id] = ($answer == null) ? '' : $answer->answer;
                }
                return view('grade-section-subjects.examinations.instances.fill-in-the-blanks', compact('instancePart', 'questions', 'navbar', 'submitUrl', 'answers'));
                break;
            case 'Select from the Wordbox':
                $answers = [];
                $items = $questions;
                $question = current($items)->choice->question;
                foreach ($items as $item){
                    $answer = DeploymentAnswer::where('deployment_instance_part_id', $instancePart->id)->where('question_id', $question->id)->where('wordbox_item_id', $item->id)->first();
                    $answers[$item->id] = ($answer == null) ? null : $answer->answer;
                }
                $choices = $question->selectFromTheWordboxChoices;
                return view('grade-section-subjects.examinations.instances.select-from-the-wordbox', compact('instancePart', 'question', 'choices', 'items', 'navbar', 'submitUrl', 'answers'));
                break;
            case 'Match Column A with Column B':
                $answers = [];
                $answerIds = [];
                $items = $questions;
                $question = current($items)->choice->question;
                $choices = [];
                foreach ($items as $item){
                    $answer = DeploymentAnswer::where('deployment_instance_part_id', $instancePart->id)->where('question_id', $question->id)->where('columns_item_id', $item->id)->first();
                    $answers[$item->id] = ($answer == null) ? null : $answer->answer;
                    $answerIds[$item->id] = ($answer == null) ? null : QuestionMatchColumnsChoice::where('question_id', $question->id)->where('text', $answer->answer)->first()->id;
                    $choices[] = $item->choice;
                }
                shuffle($choices);
                $itemCount = count($items) - $choices_quantity;
                $items = array_slice($items, 0 , $itemCount);
                return view('grade-section-subjects.examinations.instances.match-column-a-with-column-b', compact('instancePart', 'question', 'choices', 'items', 'navbar', 'submitUrl', 'answers', 'answerIds'));
            default:
                flash()->error('Some error occurred. Please try again.');
                return redirect('/home');
        }
    }

    public function processPage($instancePart, $questions, $nextUrl, $page, $request){
        $answers = $request->input('answers');
        if (!strcmp($instancePart->examinationPart->getQuestionType(), 'Match Column A with Column B')){
        } else if (count($questions) != count($answers)){
            flash()->error("Please answer all questions.");
            return redirect(URL::previous());
        } 

        switch ($instancePart->examinationPart->getQuestionType()){
            case 'Multiple Choice':
                foreach ($answers as $questionId => $answerId){
                    $existingAnswer = $this->fetchAnswer($instancePart->id, $questionId);
                    if (!is_null($existingAnswer)){
                        $existingAnswer->delete();
                    }
                    $answer = QuestionMultipleChoice::find($answerId)->text;
                    $this->recordAnswer($instancePart->id, $questionId, $answer);
                }
                break;
            case 'True or False':
                foreach ($answers as $questionId => $answer){
                    $existingAnswer = $this->fetchAnswer($instancePart->id, $questionId);
                    if (!is_null($existingAnswer)){
                        $existingAnswer->delete();
                    }
                    $this->recordAnswer($instancePart->id, $questionId, $answer);
                }
                break;
            case 'Fill in the Blanks':
                foreach ($answers as $questionId => $answer){
                    $existingAnswer = $this->fetchAnswer($instancePart->id, $questionId);
                    if (!is_null($existingAnswer)){
                        $existingAnswer->delete();
                    }
                    $this->recordAnswer($instancePart->id, $questionId, $answer);
                }
                break;
            case 'Select from the Wordbox':
                foreach ($answers as $answer){
                    if ($answer == ""){
                        flash()->error("Please answer all questions.");
                        return redirect(URL::previous());
                    }
                }
                foreach ($answers as $wordboxItemId => $answer){
                    $questionId = QuestionSelectFromTheWordboxItem::find($wordboxItemId)->choice->question->id;
                    $existingAnswer = DeploymentAnswer::where('deployment_instance_part_id', $instancePart->id)->where('question_id', $questionId)->where('wordbox_item_id', $wordboxItemId)->first();
                    if (!is_null($existingAnswer)){
                        $existingAnswer->delete();
                    }
                    $this->recordAnswer($instancePart->id, $questionId, $answer, $wordboxItemId);
                }
                break;
            case 'Match Column A with Column B':
                foreach ($answers as $answer){
                    if ($answer == ""){
                        flash()->error("Please answer all questions.");
                        return redirect(URL::previous());
                    }
                }
                foreach ($answers as $columnsItemId => $answerId){
                    $questionId = QuestionMatchColumnsItem::find($columnsItemId)->choice->question->id;
                    $existingAnswer = DeploymentAnswer::where('deployment_instance_part_id', $instancePart->id)->where('question_id', $questionId)->where('columns_item_id', $columnsItemId)->first();
                    if (!is_null($existingAnswer)){
                        $existingAnswer->delete();
                    }
                    $answer = QuestionMatchColumnsChoice::find($answerId)->text;
                    $this->recordAnswer($instancePart->id, $questionId, $answer, null, $columnsItemId);
                }
                break;
            default:
                flash()->error('Some error occurred. Please try again.');
                return redirect('/home');    
        }
        return redirect($nextUrl);
    }

    public function showResults($examination, $deploymentInstance){
        $questions = [];
        $answers = [];
        $correctAnswers = [];
        $items = [];
        foreach ($deploymentInstance->parts as $part){
            switch ($part->examinationPart->getQuestionType()){
                case 'Multiple Choice':
                    $questionsInPart = explode('|', $part->question_order);
                    foreach ($questionsInPart as $questionId){
                        $answer = DeploymentAnswer::where('deployment_instance_part_id', $part->id)->where('question_id', $questionId)->first();
                        if ($answer == null){
                            $answers[$questionId] = "<div class='bg-danger'>No answer</div>";
                        } else {
                            $answers[$questionId] = $answer->answer;
                        }
                        $correctAnswers[$questionId] = QuestionMultipleChoice::where('question_id', $questionId)->where('is_right_answer', 1)->first()->text;
                        $questions[] = Question::find($questionId);
                    }
                    break;
                case 'True or False':
                    $questionsInPart = explode('|', $part->question_order);
                    foreach ($questionsInPart as $questionId){
                        $answer = DeploymentAnswer::where('deployment_instance_part_id', $part->id)->where('question_id', $questionId)->first();
                        if ($answer == null){
                            $answers[$questionId] = "<div class='bg-danger'>No answer</div>";
                        } else {
                            $answers[$questionId] = $answer->answer;
                        }
                        $correctAnswers[$questionId] = QuestionTrueOrFalse::where('question_id', $questionId)->first()->right_answer;
                        $questions[] = Question::find($questionId);
                    }
                    break;
                case 'Fill in the Blanks':
                    $questionsInPart = explode('|', $part->question_order);
                    foreach ($questionsInPart as $questionId){
                        $answer = DeploymentAnswer::where('deployment_instance_part_id', $part->id)->where('question_id', $questionId)->first();
                        if ($answer == null){
                            $answers[$questionId] = "<div class='bg-danger'>No answer</div>";
                        } else {
                            $answers[$questionId] = $answer->answer;
                        }
                        $correctAnswers[$questionId] = QuestionFillInTheBlanks::where('question_id', $questionId)->first()->right_answer;
                        $questions[] = Question::find($questionId);
                    }
                    break;
                case 'Select from the Wordbox':
                    $questionsInPart = explode('|', $part->question_order);
                    $sub_items = [];
                    $sub_answers = [];
                    $sub_correct_answers = [];
                    foreach ($questionsInPart as $id){
                        $wordboxItemId = $id;
                        $item = QuestionSelectFromTheWordboxItem::find($wordboxItemId);
                        $questionId = $item->choice->question->id;
                        $sub_items[] = $item->text;
                        $sub_correct_answers[] = $item->choice->text;
                        $answer = DeploymentAnswer::where('deployment_instance_part_id', $part->id)->where('wordbox_item_id', $wordboxItemId)->first();
                        if ($answer == null){
                            $sub_answers[] = "<div class='bg-danger'>No answer</div>";
                        } else {
                            $sub_answers[] = $answer->answer;
                        }
                    }
                    $answers[$questionId] = $sub_answers;
                    $items[$questionId] = $sub_items;
                    $correctAnswers[$questionId] = $sub_correct_answers;
                    $questions[] = Question::find($questionId);
                    break;
                case 'Match Column A with Column B':
                    $questionsInPart = explode('|', $part->question_order);
                    $sub_items = [];
                    $sub_answers = [];
                    $sub_correct_answers = [];
                    foreach ($questionsInPart as $id){
                        $columnsId = $id;
                        $item = QuestionMatchColumnsItem::find($columnsId);
                        $questionId = $item->choice->question->id;
                        $sub_items[] = $item->text;
                        $sub_correct_answers[] = $item->choice->text;
                        $answer = DeploymentAnswer::where('deployment_instance_part_id', $part->id)->where('columns_item_id', $columnsId)->first();
                        if ($answer == null){
                            $sub_answers[] = "<div class='bg-danger'>No answer</div>";
                        } else {
                            $sub_answers[] = $answer->answer;
                        }
                    }
                    $answers[$questionId] = $sub_answers;
                    $items[$questionId] = $sub_items;
                    $correctAnswers[$questionId] = $sub_correct_answers;
                    $questions[] = Question::find($questionId);
                    break;
                default:
                    flash()->error('Some error occurred. Please try again.');
                    return redirect('/home');
            }
        }
        return view('grade-section-subjects.examinations.students.results', compact('subject', 'examination', 'instance', 'questions', 'answers', 'correctAnswers', 'items'));
    }

    public function fetchAnswer($deploymentInstancePartId, $questionId){
        return DeploymentAnswer::where('deployment_instance_part_id', $deploymentInstancePartId)->where('question_id', $questionId)->first();
    }

    public function verifyQuestionQuantity($examination){
        $count = 1;
        foreach ($examination->parts as $part){
            $questionTypeId = $part->question_type_id;
            if ($part->getQuestionType() == 'Select from the Wordbox'){
                $questionItem = $part->items()->first();
                if (is_null($questionItem)){
                    flash()->error('Part ' . $count . ' has some issues. No existing item has been added.');
                    return false;
                }
                $question = Question::find($questionItem->question_id);
                $wordboxChoiceIds = QuestionSelectFromTheWordboxChoice::where('question_id', $question->id)->pluck('id');
                $wordboxItems = QuestionSelectFromTheWordboxItem::whereIn('wordbox_choice_id', $wordboxChoiceIds)->get();
                if (count($wordboxItems) < $questionItem->quantity){
                    flash()->error('Part ' . $count . ' has some issues. The item has insufficient quantity of questions available in the question bank.');
                    return false;
                }
            } else if ($part->getQuestionType() == 'Match Column A with Column B'){
                $questionItem = $part->items()->first();
                if (is_null($questionItem)){
                    flash()->error('Part ' . $count . ' has some issues. No existing item has been added.');
                    return false;
                }
                $extraChoices = $questionItem->choices_quantity;
                $question = Question::find($questionItem->question_id);
                $columnsChoiceIds = QuestionMatchColumnsChoice::where('question_id', $question->id)->pluck('id');
                $columnsItems = QuestionMatchColumnsItem::whereIn('columns_choice_id', $columnsChoiceIds)->get();
                if ((count($columnsItems) < $questionItem->quantity) || (count($columnsItems) < $questionItem->quantity + $extraChoices)){
                    flash()->error('Part ' . $count . ' has some issues. The item has insufficient quantity of questions available in the question bank.');
                    return false;
                }
            } else {
                if ($part->items->isEmpty()){
                    flash()->error('Part ' . $count . ' has some issues. No existing items have been added.');
                    return false;
                }
                foreach ($part->items as $item){
                    $questions = Question::where('question_type_id', $questionTypeId)->where('question_subtopic_id', $item->question_subtopic_id)->get()->shuffle();
                    if (count($questions) < $item->quantity){
                        flash()->error('Part ' . $count . ' has some issues. One of the items has insufficient quantity of questions available in the question bank.');
                        return false;
                    }
                }
            }
            if ($part->questions_quantity != $part->getQuestionsCount()){
                flash()->error('Part ' . $count . ' has some issues. The number of questions in this part does not match the quantity required by the part.');
                return false;
            }
            $count++;
        }
        return true;
    }

    private function recordAnswer($deploymentInstancePartId, $questionId, $answer, $wordboxItemId = null, $columnsItemId = null){
        $deploymentAnswer = new DeploymentAnswer;
        $deploymentAnswer->deployment_instance_part_id = $deploymentInstancePartId;
        $deploymentAnswer->question_id = $questionId;
        $deploymentAnswer->wordbox_item_id = $wordboxItemId;
        $deploymentAnswer->columns_item_id = $columnsItemId;
        $deploymentAnswer->answer = $answer;
        $deploymentAnswer->save();
    }
}
