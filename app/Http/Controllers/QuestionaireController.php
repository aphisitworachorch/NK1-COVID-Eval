<?php

namespace App\Http\Controllers;

use App\Models\QuestionaireAnswers;
use App\Models\QuestionairePrototype;
use App\Models\QuestionairePrototypeDesc;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionaireController extends Controller
{
    public function testMakeQuestionaire():\Illuminate\Http\JsonResponse
    {
        $question = new QuestionairePrototype;
        $question->sections_id = 2;
        $question->question_type = 1;
        $question->question_title = 'test';
        $question->save();
        if($question->id){
            $question_det = new QuestionairePrototypeDesc;
            $question_det->questionaire_id = $question->id;
            $question_det->choices = json_encode(array(
                "choice_1"=>array(
                    "title"=>"คุณไป 14 จังหวัดมาหรือไม่",
                    "type"=>"true_or_false",
                    "choices_type"=>array(true,false)
                ),
                "choice_2"=>array(
                    "title"=>"คุณไป 28 จังหวัดมาหรือไม่",
                    "type"=>"true_or_false",
                    "choices_type"=>array(true,false)
                )
            ));
            $question_det->save();

            $question_ans = new QuestionaireAnswers;
            $question_ans->questionaire_id = $question->id;
            $question_ans->prefix = "MR";
            $question_ans->name = "ASANAN";
            $question_ans->surname = "APHISITWORACHORCH";
            $question_ans->church = "NEXUS NAK1";
            $question_ans->care_group = "NT1";
            $question_ans->answers = json_encode(array(
                "choice_1"=>array(
                    "answers"=>false
                )
            ));
            $question_ans->save();
        }
        return response()->json(QuestionaireAnswers::all());
    }

    public function showForm(Request $request){
        $question = QuestionairePrototypeDesc::with('questionPrototype')->get()->toJson();
        return Inertia::render('COVID/Evaluation',['form'=>$question]);
    }
}
